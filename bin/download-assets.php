<?php
declare(strict_types=1);

echo "=== [EbonyCraft Palu] Unduh Aset Vendor Lokal (ApexCharts) ===\n";

$targetDir = __DIR__ . '/../public/assets/vendor';
if (!is_dir($targetDir)) {
    mkdir($targetDir, 0777, true);
}

$url = 'https://cdn.jsdelivr.net/npm/apexcharts/dist/apexcharts.min.js';
$targetFile = $targetDir . '/apexcharts.min.js';

echo "[+] Mengunduh ApexCharts dari {$url}...\n";
$content = @file_get_contents($url);

if ($content && strlen($content) > 1000) {
    file_put_contents($targetFile, $content);
    $sizeKb = round(strlen($content) / 1024, 1);
    echo "[✓] Berhasil menyimpan {$targetFile} ({$sizeKb} KB)!\n";
    echo "[✓] Dashboard kini dapat dijalankan 100% offline tanpa internet.\n";
} else {
    echo "[!] Tidak dapat mengunduh secara otomatis (periksa koneksi internet).\n";
    echo "    Catatan: Halaman web akan otomatis memuat CDN jika file lokal belum tersedia.\n";
}
