@echo off
title EbonyCraft Palu - Setup Database
echo ========================================================
echo [EbonyCraft Palu] Setup & Inisialisasi Database
echo ========================================================
echo Menghubungkan ke MySQL XAMPP (Port 3307)...
echo.

php bin/migrate.php
if errorlevel 1 (
    echo.
    echo [ERROR] Gagal migrasi basis data. Pastikan MySQL di XAMPP Control Panel sudah berjalan.
    pause
    exit /b 1
)

echo.
echo Mengisi data transaksi simulasi 46 bulan realistis...
php database/seeders/seed.php --fresh
if errorlevel 1 (
    echo.
    echo [ERROR] Gagal menjalankan seeder data.
    pause
    exit /b 1
)

echo.
echo Menjalankan pipeline algoritma prediksi penjualan...
php bin/forecast.php
if errorlevel 1 (
    echo.
    echo [ERROR] Gagal kalkulasi prediksi.
    pause
    exit /b 1
)

echo.
echo ========================================================
echo [SUKSES] Database 'ebonycraft' berhasil dibuat di phpMyAdmin!
echo Seluruh 11 tabel, 46 bulan transaksi, dan 25 chart siap.
echo ========================================================
echo Silakan refresh browser Anda: http://localhost/ebonycraft-palu/public/
echo.
pause
