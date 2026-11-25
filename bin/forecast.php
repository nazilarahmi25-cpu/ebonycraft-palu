<?php
declare(strict_types=1);

require_once __DIR__ . '/../src/bootstrap.php';

use App\Services\ForecastService;

echo "=== [EbonyCraft Palu] Menjalankan Pipeline Prediksi Penjualan ===\n";

try {
    $service = new ForecastService();
    $start = microtime(true);
    $res = $service->runPipeline();
    $elapsed = round(microtime(true) - $start, 2);

    echo "[✓] Kalkulasi 3 Model Selesai ({$elapsed} detik)!\n";
    echo "    - Model Terpilih : " . strtoupper(str_replace('_', ' ', $res['selected_model'])) . "\n";
    echo "    - Akurasi (MAPE) : " . $res['mape'] . "%\n";
    echo "    - Status Evaluasi: " . ($res['mape'] <= 15.0 ? "MEMENUHI SYARAT (≤ 15%)" : "EVALUASI") . "\n";
    echo "[✓] Nilai prediksi 12 bulan & kategori tersimpan di basis data.\n";
    echo "=== Pipeline Prediksi Berhasil ===\n";
} catch (Throwable $e) {
    echo "[!] Kesalahan kalkulasi prediksi: " . $e->getMessage() . "\n";
    exit(1);
}
