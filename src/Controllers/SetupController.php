<?php
declare(strict_types=1);

namespace App\Controllers;

use App\Core\Request;
use App\Core\Response;
use App\Services\SetupService;
use Throwable;

class SetupController
{
    public function apiSetup(Request $request): void
    {
        try {
            $result = SetupService::initializeDatabase();
            Response::json($result);
        } catch (Throwable $e) {
            Response::error('Gagal setup database: ' . $e->getMessage(), 'SETUP_ERROR', 500);
        }
    }

    public function webSetup(Request $request): void
    {
        $base = dirname($_SERVER['SCRIPT_NAME'] ?? '');
        if ($base === '/' || $base === '\\') $base = '';

        try {
            $result = SetupService::initializeDatabase();
            echo "<!DOCTYPE html><html lang='id'><head><meta charset='utf-8'><title>Setup Sukses</title>";
            echo "<style>body{font-family:sans-serif;background:#FAF6EE;color:#2A211B;padding:40px;text-align:center;}";
            echo ".box{background:#fff;border:1px solid #E8D8BD;border-radius:14px;padding:32px;max-width:540px;margin:0 auto;}";
            echo ".btn{display:inline-block;padding:10px 20px;background:#C8892B;color:#1C1410;text-decoration:none;border-radius:8px;font-weight:bold;margin-top:20px;}";
            echo "</style></head><body>";
            echo "<div class='box'>";
            echo "<h1 style='color:#3F6B4F;'>✓ Setup Database Berhasil!</h1>";
            echo "<p>{$result['message']}</p>";
            echo "<p style='font-size:13px;color:#7C6F64;'>Basis data <strong>{$result['database']}</strong> pada port <strong>{$result['port']}</strong> telah berisi 11 tabel lengkap, 46 bulan transaksi dummy realistis, dan modul prediksi penjualan.</p>";
            echo "<a href='{$base}/' class='btn'>Buka Dashboard Sekarang →</a>";
            echo "</div></body></html>";
        } catch (Throwable $e) {
            echo "<!DOCTYPE html><html lang='id'><head><meta charset='utf-8'><title>Setup Gagal</title>";
            echo "<style>body{font-family:sans-serif;background:#FAF6EE;color:#2A211B;padding:40px;text-align:center;}";
            echo ".box{background:#fff;border:1px solid #B3402E;border-radius:14px;padding:32px;max-width:540px;margin:0 auto;}";
            echo ".btn{display:inline-block;padding:10px 20px;background:#2A211B;color:#fff;text-decoration:none;border-radius:8px;margin-top:20px;}";
            echo "</style></head><body>";
            echo "<div class='box'>";
            echo "<h1 style='color:#B3402E;'>Gagal Setup Database</h1>";
            echo "<p>" . htmlspecialchars($e->getMessage()) . "</p>";
            echo "<p style='font-size:13px;color:#7C6F64;'>Pastikan MySQL XAMPP sudah berjalan pada port 3307.</p>";
            echo "<a href='{$base}/setup' class='btn'>Coba Lagi</a>";
            echo "</div></body></html>";
        }
    }
}
