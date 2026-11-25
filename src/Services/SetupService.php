<?php
declare(strict_types=1);

namespace App\Services;

use App\Core\Env;
use App\Core\Cache;
use App\Repositories\UserRepository;
use PDO;
use Throwable;

class SetupService
{
    public static function initializeDatabase(): array
    {
        $host   = Env::get('DB_HOST', '127.0.0.1');
        $port   = Env::get('DB_PORT', '3307');
        $dbName = Env::get('DB_NAME', 'ebonycraft');
        $user   = Env::get('DB_USER', 'root');
        $pass   = Env::get('DB_PASS', '');

        // 1. Connect without dbname to root to create database
        $rootDsn = "mysql:host={$host};port={$port};charset=utf8mb4";
        $options = [
            PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
            PDO::ATTR_EMULATE_PREPARES   => false,
        ];

        $rootPdo = new PDO($rootDsn, $user, $pass, $options);
        $rootPdo->exec("CREATE DATABASE IF NOT EXISTS `{$dbName}` CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;");

        // 2. Connect to the created database
        $dbDsn = "mysql:host={$host};port={$port};dbname={$dbName};charset=utf8mb4";
        $pdo = new PDO($dbDsn, $user, $pass, $options);

        // 3. Import schema.sql
        $schemaFile = __DIR__ . '/../../database/schema.sql';
        if (file_exists($schemaFile)) {
            $sql = file_get_contents($schemaFile);
            $pdo->exec($sql);
        }

        // 4. Seed Categories & 18 Products
        self::seedMaster($pdo);

        // 5. Seed 46 Months Realistic Transactions
        self::seedTransactions($pdo);

        // 6. Create default admin
        $userRepo = new UserRepository($pdo);
        $adminUser = Env::get('ADMIN_USER', 'admin');
        $adminPass = Env::get('ADMIN_PASS', 'admin123');
        $userRepo->createOrUpdateAdmin($adminUser, $adminPass);

        // 7. Run Forecast Pipeline
        $salesRepo = new \App\Repositories\SalesRepository($pdo);
        $prodRepo  = new \App\Repositories\ProductRepository($pdo);
        $fcRepo    = new \App\Repositories\ForecastRepository($pdo);
        $fcService = new ForecastService($salesRepo, $prodRepo, $fcRepo);
        $fcResult  = $fcService->runPipeline();

        Cache::flush();

        return [
            'status'   => 'success',
            'database' => $dbName,
            'port'     => $port,
            'message'  => "Basis data '{$dbName}' berhasil dibuat pada port {$port} dan seluruh 25 chart siap!",
            'forecast' => $fcResult,
        ];
    }

    private static function seedMaster(PDO $pdo): void
    {
        $categories = [
            1 => 'Aksesoris',
            2 => 'Dekorasi & Patung',
            3 => 'Souvenir',
            4 => 'Alat Tulis & Fungsional',
            5 => 'Religi & Seremonial',
        ];

        $stmtCat = $pdo->prepare("INSERT INTO categories (id, name) VALUES (:id, :name) ON DUPLICATE KEY UPDATE name = VALUES(name)");
        foreach ($categories as $id => $name) {
            $stmtCat->execute(['id' => $id, 'name' => $name]);
        }

        $products = [
            ['EBN-AKS-01', 'Gelang Eboni Polos', 1, 85000, 51000, 4],
            ['EBN-AKS-02', 'Gelang Eboni Ukir', 1, 150000, 88000, 6],
            ['EBN-AKS-03', 'Cincin Eboni', 1, 65000, 38000, 3],
            ['EBN-AKS-04', 'Liontin Kalung', 1, 120000, 70000, 5],

            ['EBN-DKR-01', 'Miniatur Penari Pamonte', 2, 450000, 260000, 14],
            ['EBN-DKR-02', 'Patung Kepala Adat', 2, 650000, 370000, 21],
            ['EBN-DKR-03', 'Topeng Hias Dinding', 2, 380000, 220000, 12],
            ['EBN-DKR-04', 'Patung Burung Maleo', 2, 520000, 300000, 16],

            ['EBN-SVN-01', 'Gantungan Kunci', 3, 25000, 15000, 3],
            ['EBN-SVN-02', 'Magnet Kulkas Ukir', 3, 35000, 21000, 4],
            ['EBN-SVN-03', 'Set Souvenir Wisata', 3, 95000, 56000, 5],

            ['EBN-ATK-01', 'Pulpen Eboni', 4, 55000, 33000, 4],
            ['EBN-ATK-02', 'Sisir Eboni', 4, 45000, 27000, 4],
            ['EBN-ATK-03', 'Kotak Perhiasan', 4, 275000, 160000, 10],
            ['EBN-ATK-04', 'Tongkat Hias', 4, 350000, 205000, 12],

            ['EBN-RLG-01', 'Tasbih Eboni', 5, 175000, 102000, 7],
            ['EBN-RLG-02', 'Rehal Eboni', 5, 320000, 188000, 11],
            ['EBN-RLG-03', 'Hiasan Kaligrafi', 5, 480000, 280000, 14],
        ];

        $stmtProd = $pdo->prepare("
            INSERT INTO products (sku, name, category_id, price, hpp, lead_time_base)
            VALUES (?, ?, ?, ?, ?, ?)
            ON DUPLICATE KEY UPDATE name=VALUES(name), price=VALUES(price), hpp=VALUES(hpp)
        ");
        foreach ($products as $p) {
            $stmtProd->execute($p);
        }

        $channels = [
            [1, 'Toko Offline', 0],
            [2, 'Instagram', 1],
            [3, 'WhatsApp', 1],
            [4, 'Marketplace', 1],
            [5, 'Pameran/Event', 0],
            [6, 'Reseller/Korporat', 0],
        ];
        $stmtCh = $pdo->prepare("INSERT INTO channels (id, name, is_online) VALUES (?, ?, ?) ON DUPLICATE KEY UPDATE name=VALUES(name)");
        foreach ($channels as $ch) {
            $stmtCh->execute($ch);
        }

        $regions = [
            [1, 'Kota Palu', 'Sulawesi Tengah'],
            [2, 'Kab. Sigi', 'Sulawesi Tengah'],
            [3, 'Kab. Donggala', 'Sulawesi Tengah'],
            [4, 'Kab. Parigi Moutong', 'Sulawesi Tengah'],
            [5, 'Kab. Poso', 'Sulawesi Tengah'],
            [6, 'Makassar', 'Domestik Luar Sulteng'],
            [7, 'Jakarta', 'Domestik Luar Sulteng'],
            [8, 'Surabaya', 'Domestik Luar Sulteng'],
            [9, 'Kalimantan', 'Domestik Luar Sulteng'],
            [10, 'Wilayah Lainnya', 'Domestik Luar Sulteng'],
            [11, 'Luar Negeri', 'Luar Negeri'],
        ];
        $stmtReg = $pdo->prepare("INSERT INTO regions (id, name, region_group) VALUES (?, ?, ?) ON DUPLICATE KEY UPDATE name=VALUES(name)");
        foreach ($regions as $reg) {
            $stmtReg->execute($reg);
        }
    }

    private static function seedTransactions(PDO $pdo): void
    {
        $dbProducts = $pdo->query("SELECT * FROM products ORDER BY id ASC")->fetchAll();
        $numProducts = count($dbProducts);

        mt_srand(2026);

        $startYear = 2023;
        $startMonth = 1;
        $totalMonths = 46;
        $baseRevenue = 28000000;
        $growthRate = 0.010;

        $seasonIndex = [
            1 => 1.05, 2 => 0.80, 3 => 0.95, 4 => 1.00,
            5 => 0.95, 6 => 1.10, 7 => 1.15, 8 => 1.00,
            9 => 1.10, 10 => 0.90, 11 => 0.95, 12 => 1.35
        ];

        $ramadanMonths = ['2023-04' => true, '2024-04' => true, '2025-03' => true, '2026-03' => true];

        $zipfWeights = [];
        for ($i = 1; $i <= $numProducts; $i++) {
            $zipfWeights[$i - 1] = 1.0 / pow($i, 0.92);
        }

        $segments = ['Wisatawan', 'Warga Lokal', 'Instansi', 'Reseller', 'Kolektor'];
        $segmentWeights = [32, 28, 12, 14, 14];
        $regionWeights = [
            1 => 42, 2 => 6, 3 => 6, 4 => 4, 5 => 3,
            6 => 8, 7 => 10, 8 => 4, 9 => 4, 10 => 11, 11 => 2
        ];

        $firstNames = ['Budi', 'Agus', 'Siti', 'Dewi', 'Andi', 'Nur', 'Rian', 'Fajar', 'Eka', 'Hendra', 'Maya', 'Dian'];
        $lastNames  = ['Santoso', 'Pratama', 'Hidayat', 'Kusuma', 'Lestari', 'Tadulako', 'Palawa', 'Marantika'];

        $stmtInsCust = $pdo->prepare("INSERT INTO customers (id, name, segment, region_id, first_order_date) VALUES (?, ?, ?, ?, ?)");
        $stmtInsOrder = $pdo->prepare("INSERT INTO orders (id, order_no, order_date, customer_id, channel_id, region_id, payment_method, discount, shipping_cost, is_repeat, net_total) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
        $stmtInsItem = $pdo->prepare("INSERT INTO order_items (order_id, product_id, qty, unit_price, unit_hpp, subtotal) VALUES (?, ?, ?, ?, ?, ?)");
        $stmtInsBatch = $pdo->prepare("INSERT INTO production_batches (product_id, batch_date, qty, lead_time_days) VALUES (?, ?, ?, ?)");
        $stmtInsInv = $pdo->prepare("INSERT INTO inventory_snapshots (product_id, month, closing_stock) VALUES (?, ?, ?)");
        $stmtInsCost = $pdo->prepare("INSERT INTO monthly_costs (month, cost_type, amount) VALUES (?, ?, ?)");

        $customerId = 1;
        $orderId = 1;
        $customerPool = [];

        $pdo->beginTransaction();

        for ($m = 0; $m < $totalMonths; $m++) {
            $curYear = $startYear + (int)floor(($startMonth - 1 + $m) / 12);
            $curMonthNum = (($startMonth - 1 + $m) % 12) + 1;
            $periodStr = sprintf('%04d-%02d', $curYear, $curMonthNum);
            $firstDay = $periodStr . '-01';
            $daysInMonth = (int)date('t', strtotime($firstDay));

            $yearOffset = $curYear - 2023;
            $chWeight = [
                1 => max(25, 42 - ($yearOffset * 5)),
                2 => 14 + ($yearOffset * 2),
                3 => 14 + ($yearOffset * 1),
                4 => 7 + ($yearOffset * 4),
                5 => max(8, 15 - ($yearOffset * 2)),
                6 => 8,
            ];

            $repeatRate = 0.18 + ($yearOffset * 0.043);

            $sFactor = $seasonIndex[$curMonthNum];
            $eventFactor = isset($ramadanMonths[$periodStr]) ? 1.08 : 1.0;
            if ($curMonthNum === 10 && mt_rand(1, 10) <= 8) {
                $eventFactor *= 1.25;
            }

            $u1 = mt_rand(1, 10000) / 10000;
            $u2 = mt_rand(1, 10000) / 10000;
            $noise = exp(sqrt(-2.0 * log($u1)) * cos(2.0 * M_PI * $u2) * 0.075);
            $targetMonthRev = $baseRevenue * pow(1 + $growthRate, $m) * $sFactor * $eventFactor * $noise;

            $approxOrders = (int)round($targetMonthRev / 280000);
            $monthHppSum = 0;
            $monthlySales = array_fill_keys(array_column($dbProducts, 'id'), 0);

            for ($o = 0; $o < $approxOrders; $o++) {
                $day = mt_rand(1, $daysInMonth);
                $orderDate = sprintf('%s-%02d', $periodStr, $day);

                $channelId = self::weightedRand($chWeight);
                $isRepeat = (!empty($customerPool) && (mt_rand(1, 100) / 100.0) <= $repeatRate);

                if ($isRepeat) {
                    $cKey = array_rand($customerPool);
                    $selectedCustId = $cKey;
                    $regId = $customerPool[$cKey]['region_id'];
                } else {
                    $selectedCustId = $customerId++;
                    $regId = self::weightedRand($regionWeights);
                    $segName = $segments[self::weightedRand($segmentWeights)];
                    $cName = $firstNames[array_rand($firstNames)] . ' ' . $lastNames[array_rand($lastNames)];

                    $stmtInsCust->execute([$selectedCustId, $cName, $segName, $regId, $orderDate]);
                    $customerPool[$selectedCustId] = ['segment' => $segName, 'region_id' => $regId];
                }

                $itemRoll = mt_rand(1, 100);
                $itemCount = $itemRoll <= 62 ? 1 : ($itemRoll <= 88 ? 2 : 3);

                $paymentMethod = $channelId === 4 ? 'Marketplace' : ($channelId === 1 ? (mt_rand(1, 100) <= 60 ? 'Tunai' : 'QRIS') : 'Transfer');

                $orderSubtotal = 0;
                $orderHpp = 0;
                $orderItems = [];

                for ($it = 0; $it < $itemCount; $it++) {
                    $prodIdx = self::weightedRand($zipfWeights);
                    $p = $dbProducts[$prodIdx];
                    $qty = ($p['category_id'] == 3 && mt_rand(1, 100) <= 45) ? mt_rand(2, 5) : 1;

                    $sub = $p['price'] * $qty;
                    $hpp = $p['hpp'] * $qty;
                    $orderSubtotal += $sub;
                    $orderHpp += $hpp;

                    $orderItems[] = [$p['id'], $qty, $p['price'], $p['hpp'], $sub];
                    $monthlySales[$p['id']] += $qty;
                }

                $discount = ($orderSubtotal >= 500000 && mt_rand(1, 100) <= 30) ? (int)(round($orderSubtotal * 0.05 / 1000) * 1000) : 0;
                $net = max(0, $orderSubtotal - $discount);
                $orderNo = sprintf('ORD-%s-%04d', str_replace('-', '', $periodStr), $orderId);

                $stmtInsOrder->execute([
                    $orderId, $orderNo, $orderDate, $selectedCustId, $channelId,
                    $regId, $paymentMethod, $discount, 0, $isRepeat ? 1 : 0, $net
                ]);

                foreach ($orderItems as $item) {
                    $stmtInsItem->execute([$orderId, $item[0], $item[1], $item[2], $item[3], $item[4]]);
                }

                $orderId++;
                $monthHppSum += $orderHpp;
            }

            // Operations & Costs
            foreach ($dbProducts as $p) {
                $sold = $monthlySales[$p['id']];
                $batchQty = max(5, (int)round($sold * (mt_rand(90, 125) / 100)));
                $leadTime = max(2, (int)round($p['lead_time_base'] * (mt_rand(85, 120) / 100)));
                $stmtInsBatch->execute([$p['id'], $orderDate, $batchQty, $leadTime]);

                $targetStock = (int)round($sold * 1.5) + mt_rand(2, 10);
                $stmtInsInv->execute([$p['id'], $firstDay, $targetStock]);
            }

            $bb = (int)round($monthHppSum * 0.45);
            $tk = (int)round($monthHppSum * 0.30);
            $fn = (int)round($monthHppSum * 0.15);
            $km = $monthHppSum - ($bb + $tk + $fn);

            $stmtInsCost->execute([$firstDay, 'bahan_baku', $bb]);
            $stmtInsCost->execute([$firstDay, 'tenaga_kerja', $tk]);
            $stmtInsCost->execute([$firstDay, 'finishing', $fn]);
            $stmtInsCost->execute([$firstDay, 'kemasan', $km]);

            $stmtInsCost->execute([$firstDay, 'promosi', (int)round($targetMonthRev * 0.05)]);
            $stmtInsCost->execute([$firstDay, 'ongkir', (int)round($targetMonthRev * 0.03)]);
            $stmtInsCost->execute([$firstDay, 'biaya_platform', (int)round($targetMonthRev * 0.03)]);
            $stmtInsCost->execute([$firstDay, 'lainnya', (int)round($targetMonthRev * 0.02)]);
        }

        $pdo->commit();
    }

    private static function weightedRand(array $weights): int
    {
        $r = mt_rand(1, (int)array_sum($weights));
        $acc = 0;
        foreach ($weights as $k => $w) {
            $acc += $w;
            if ($r <= $acc) return $k;
        }
        return array_key_first($weights);
    }
}
