<?php
declare(strict_types=1);

namespace App\Services;

use App\Core\Cache;
use App\Core\Database;
use PDO;

class ImportService
{
    private PDO $db;

    public function __construct(?PDO $db = null)
    {
        $this->db = $db ?? Database::getInstance();
    }

    public function importCsv(string $filePath): array
    {
        if (!file_exists($filePath) || !is_readable($filePath)) {
            throw new \InvalidArgumentException("File CSV tidak ditemukan atau tidak dapat dibaca.");
        }

        $handle = fopen($filePath, 'r');
        if (!$handle) {
            throw new \RuntimeException("Gagal membuka file CSV.");
        }

        // Read header
        $header = fgetcsv($handle);
        if (!$header) {
            fclose($handle);
            throw new \InvalidArgumentException("File CSV kosong.");
        }

        // Normalize header
        $header = array_map(fn($col) => strtolower(trim(preg_replace('/[\x00-\x1F\x80-\xFF]/', '', $col))), $header);
        $expectedCols = ['order_no', 'order_date', 'customer_name', 'product_sku', 'qty'];
        foreach ($expectedCols as $col) {
            if (!in_array($col, $header)) {
                fclose($handle);
                throw new \InvalidArgumentException("Kolom wajib '{$col}' tidak ditemukan di file CSV.");
            }
        }

        $colMap = array_flip($header);
        $rowNum = 1;
        $successCount = 0;
        $errors = [];

        // Preload maps
        $productMap = $this->db->query("SELECT sku, id, price, hpp FROM products")->fetchAll(PDO::FETCH_UNIQUE | PDO::FETCH_ASSOC);
        $channelMap = $this->db->query("SELECT name, id FROM channels")->fetchAll(PDO::FETCH_KEY_PAIR);
        $regionMap  = $this->db->query("SELECT name, id FROM regions")->fetchAll(PDO::FETCH_KEY_PAIR);

        $defaultChannelId = reset($channelMap) ?: 1;
        $defaultRegionId  = reset($regionMap) ?: 1;

        $this->db->beginTransaction();

        try {
            while (($row = fgetcsv($handle)) !== false) {
                $rowNum++;
                if (count($row) < count($expectedCols)) {
                    $errors[] = "Baris {$rowNum}: Kolom tidak lengkap.";
                    continue;
                }

                $orderNo  = trim($row[$colMap['order_no']] ?? '');
                $date     = trim($row[$colMap['order_date']] ?? '');
                $custName = trim($row[$colMap['customer_name']] ?? 'Pelanggan Walk-in');
                $sku      = trim($row[$colMap['product_sku']] ?? '');
                $qty      = (int)($row[$colMap['qty']] ?? 1);

                if (empty($orderNo) || empty($date) || empty($sku) || $qty <= 0) {
                    $errors[] = "Baris {$rowNum}: Nilai order_no, tanggal, SKU, atau qty tidak valid.";
                    continue;
                }

                if (!isset($productMap[$sku])) {
                    $errors[] = "Baris {$rowNum}: SKU '{$sku}' tidak terdaftar di master produk.";
                    continue;
                }

                $product = $productMap[$sku];
                $prodId   = (int)$product['id'];
                $price    = (int)$product['price'];
                $hpp      = (int)$product['hpp'];
                $subtotal = $price * $qty;

                // 1. Ensure Customer
                $stmtCust = $this->db->prepare("SELECT id FROM customers WHERE name = :name LIMIT 1");
                $stmtCust->execute(['name' => $custName]);
                $custId = $stmtCust->fetchColumn();

                if (!$custId) {
                    $stmtInsCust = $this->db->prepare("
                        INSERT INTO customers (name, segment, region_id, first_order_date)
                        VALUES (:name, 'Wisatawan', :region_id, :fod)
                    ");
                    $stmtInsCust->execute([
                        'name'      => $custName,
                        'region_id' => $defaultRegionId,
                        'fod'       => $date,
                    ]);
                    $custId = (int)$this->db->lastInsertId();
                }

                // 2. Ensure Order
                $stmtOrd = $this->db->prepare("SELECT id FROM orders WHERE order_no = :ono LIMIT 1");
                $stmtOrd->execute(['ono' => $orderNo]);
                $orderId = $stmtOrd->fetchColumn();

                if (!$orderId) {
                    $stmtInsOrd = $this->db->prepare("
                        INSERT INTO orders (order_no, order_date, customer_id, channel_id, region_id, payment_method, discount, shipping_cost, is_repeat, net_total)
                        VALUES (:ono, :odate, :cid, :chid, :regid, 'Transfer', 0, 0, 0, :net)
                    ");
                    $stmtInsOrd->execute([
                        'ono'   => $orderNo,
                        'odate' => $date,
                        'cid'   => $custId,
                        'chid'  => $defaultChannelId,
                        'regid' => $defaultRegionId,
                        'net'   => $subtotal,
                    ]);
                    $orderId = (int)$this->db->lastInsertId();
                } else {
                    $stmtUpdOrd = $this->db->prepare("UPDATE orders SET net_total = net_total + :sub WHERE id = :oid");
                    $stmtUpdOrd->execute(['sub' => $subtotal, 'oid' => $orderId]);
                }

                // 3. Insert Order Item
                $stmtItem = $this->db->prepare("
                    INSERT INTO order_items (order_id, product_id, qty, unit_price, unit_hpp, subtotal)
                    VALUES (:oid, :pid, :qty, :uprice, :uhpp, :sub)
                ");
                $stmtItem->execute([
                    'oid'    => $orderId,
                    'pid'    => $prodId,
                    'qty'    => $qty,
                    'uprice' => $price,
                    'uhpp'   => $hpp,
                    'sub'    => $subtotal,
                ]);

                $successCount++;
            }

            $this->db->commit();
            fclose($handle);

            // Flush cache
            Cache::flush();

            return [
                'status'        => 'success',
                'imported_rows' => $successCount,
                'errors'        => $errors,
            ];
        } catch (\Throwable $e) {
            $this->db->rollBack();
            fclose($handle);
            throw $e;
        }
    }
}
