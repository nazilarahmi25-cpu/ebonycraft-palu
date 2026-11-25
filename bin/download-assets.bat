@echo off
echo Mengunduh apexcharts.min.js ke public\assets\vendor\ ...
curl -s -L https://cdn.jsdelivr.net/npm/apexcharts/dist/apexcharts.min.js -o public\assets\vendor\apexcharts.min.js
if exist public\assets\vendor\apexcharts.min.js (
    echo [OK] ApexCharts berhasil diunduh ke public\assets\vendor\apexcharts.min.js
) else (
    echo [FAIL] Gagal mengunduh ApexCharts. Browser akan menggunakan CDN cadangan.
)
pause
