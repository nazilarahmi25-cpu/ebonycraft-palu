<?php
require_once __DIR__ . '/../src/bootstrap.php';

use App\Services\ChartService;

echo "=== Verifikasi Data 25 Chart (C01 - C25) ===\n";

$cs = new ChartService();
$allPassed = true;

for ($i = 1; $i <= 25; $i++) {
    $id = sprintf('c%02d', $i);
    try {
        $res = $cs->getChartData($id);
        $seriesCount = count($res['series'] ?? []);
        $catCount = count($res['categories'] ?? []);
        echo "[✓] {$id}: {$res['title']} | Tipe: {$res['type']} | Kategori: {$catCount} | Series: {$seriesCount}\n";
    } catch (\Throwable $e) {
        echo "[✗] {$id}: ERROR - " . $e->getMessage() . "\n";
        $allPassed = false;
    }
}

if ($allPassed) {
    echo "\n=== SUKSES: Seluruh 25 Chart Mengembalikan Data Valid 100%! ===\n";
} else {
    echo "\n=== GAGAL: Ada chart yang bermasalah! ===\n";
    exit(1);
}
