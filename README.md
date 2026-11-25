# EbonyCraft Palu

**Analisis dan Prediksi Penjualan UMKM Sumber Urip Ebony (Kerajinan Kayu Eboni Khas Sulteng)**

EbonyCraft Palu adalah dashboard analitik dan sistem prediksi penjualan berbasis web untuk membantu UMKM pengrajin kayu eboni (*Diospyros celebica*) di Palu, Sulawesi Tengah. Sistem ini dirancang untuk menjawab pertanyaan bisnis strategis terkait produk paling menguntungkan, tren musiman, pergeseran kanal penjualan ke online, serta proyeksi permintaan 12 bulan ke depan untuk perencanaan bahan baku dan stok.

---

## 🌟 Fitur Utama

1. **Navigasi Atas (Top Navigation Buttons) & Akses Publik 25 Chart:**
   - Seluruh **25 Chart interaktif** dapat diakses secara **publik** langsung di halaman dashboard utama (`/`). Pengunjung umum tidak perlu login untuk melihat seluruh data analitik, pola musiman, dan hasil prediksi.
   - Tombol-tombol navigasi modern terletak di bagian **ATAS (Top Navigation Bar)** untuk berpindah kategori atau menampilkan sekaligus:
     - `[📊 Semua 25 Chart]`
     - `[📈 Ringkasan (C01–C05)]`
     - `[🪵 Produk (C06–C10)]`
     - `[🌐 Channel & Wilayah (C11–C14)]`
     - `[👥 Pelanggan (C15–C18)]`
     - `[⚙️ Operasional (C19–C21)]`
     - `[🔮 Prediksi 12 Bulan (C22–C25)]`
2. **Katalog Lengkap 25 Chart:** Dibuat dengan tema terpadu kerajinan kayu eboni khas Sulawesi Tengah dan palet warna serat kayu alami.
3. **Login Khusus Admin:**
   - Login hanya diperuntukkan bagi admin untuk menjalankan tugas administratif, yaitu **menghitung ulang model prediksi** secara langsung dari web dan **mengimpor data transaksi baru (.CSV)**.
   - Publik dapat mengekspor data CSV dan mengunduh gambar PNG dari setiap chart secara bebas tanpa login.
3. **Modul Prediksi Native PHP (Multi-Model):**
   - **Holt-Winters (Triple Exponential Smoothing):** Parameter optimal dicari via grid search $(\alpha, \beta, \gamma)$.
   - **Regresi Tren + Dummy Musiman (OLS):** Eliminasi Gauss-Jordan 13 parameter.
   - **Seasonal Moving Average (SMA):** Pembanding baseline tren rata-rata bergerak 12 bulan.
   - **Evaluasi Otomatis:** Holdout 12 bulan terakhir dengan pemilihan model MAPE terendah (target $\le 15\%$).
4. **Insight Otomatis:** Narasi kalimat berbahasa Indonesia di setiap halaman yang merangkum data secara langsung.
5. **Panel Admin:** Autentikasi sesi, ekspor data CSV, proteksi CSRF, serta kemampuan menghitung ulang prediksi dan mengimpor file transaksi baru (CSV).

---

## 🛠️ Persyaratan Sistem

- **PHP:** Versi 8.2 atau lebih baru (ekstensi `pdo`, `pdo_mysql`, `json`, `mbstring` aktif).
- **Database:** MySQL 8.0+ atau MariaDB 10.6+ (tersedia bawaan di XAMPP / Laragon).
- **Web Server:** Apache dengan modul `mod_rewrite` aktif.
- **Browser:** Google Chrome, Microsoft Edge, Firefox, atau Safari versi modern.

---

## 🚀 Panduan Instalasi & Menjalankan Proyek

### 1. Konfigurasi Lingkungan (`.env`)
Salin file konfigurasi `.env.example` menjadi `.env` (atau periksa file `.env` yang sudah ada):
```ini
APP_NAME="EbonyCraft Palu"
APP_ENV=local
APP_DEBUG=true
APP_URL=http://localhost/ebonycraft-palu/public
APP_TIMEZONE=Asia/Makassar

DB_HOST=127.0.0.1
DB_PORT=3306
DB_NAME=ebonycraft
DB_USER=root
DB_PASS=

CACHE_TTL=600
SEED=2026

ADMIN_USER=admin
ADMIN_PASS=admin123
```

### 2. Migrasi Database & Seeder Data
Pastikan layanan MySQL di XAMPP Control Panel sudah berjalan (Port 3306), lalu jalankan perintah berikut di terminal:

```bash
# 1. Buat basis data dan tabel skema
php bin/migrate.php

# 2. Isi data simulasi realistis 46 bulan (Januari 2023 - Oktober 2026)
php database/seeders/seed.php --fresh

# 3. Jalankan kalkulasi modul prediksi
php bin/forecast.php
```

### 3. Jalankan Pengujian Unit
Untuk memastikan seluruh rumus metrik (MAE, RMSE, MAPE, NRMSE), algoritma forecasting, dan utilitas pendukung berfungsi 100%:
```bash
php tests/run.php
```

### 4. Buka Aplikasi di Browser
Buka browser dan akses alamat:
```
http://localhost/ebonycraft-palu/public/
```
*(Atau `http://localhost/ebonycraft-palu/` jika virtual host mengarah langsung ke folder proyek).*

---

## 🔐 Kredensial Admin Awal

- **URL Login:** `http://localhost/ebonycraft-palu/public/login`
- **Username:** `admin`
- **Password:** `admin123`

---

## 📂 Struktur Direktori Proyek

```
ebonycraft-palu/
├─ bin/
│  ├─ migrate.php             # Skrip CLI migrasi database
│  ├─ forecast.php            # Skrip CLI kalkulasi prediksi
│  ├─ clear-cache.php         # Skrip CLI pembersih cache
│  ├─ download-assets.php     # Skrip unduh vendor lokal ApexCharts
│  └─ download-assets.bat     # Skrip batch unduh cepat
├─ database/
│  ├─ schema.sql              # Skema 11 tabel database MySQL
│  └─ seeders/
│     └─ seed.php             # Generator data realistis 46 bulan
├─ docs/                      # Dokumentasi perancangan lengkap (.md)
│  ├─ ARCHITECTURE.md
│  ├─ DESIGN.md
│  ├─ PRD.md
│  ├─ TODO.md
│  └─ WORKFLOW.md
├─ public/                    # Document Root web server
│  ├─ index.php               # Front controller aplikasi
│  ├─ .htaccess               # Apache URL rewrite
│  └─ assets/
│     ├─ css/ (tokens.css, layout.css, components.css)
│     ├─ js/  (app.js, api.js, format.js, charts/registry.js)
│     └─ vendor/
├─ resources/views/           # Template antarmuka pengguna (PHP)
│  ├─ layout.php              # Layout master
│  ├─ partials/               # Sidebar, Topbar, Filterbar
│  ├─ pages/                  # 6 halaman dashboard analitik
│  └─ auth/                   # Halaman login admin
├─ src/
│  ├─ Core/                   # Router, Database, Request, Response, Cache, Auth, Csrf, View
│  ├─ Controllers/            # Page, Chart, Kpi, Filter, Forecast, Export, Auth, Import
│  ├─ Services/               # ChartService, KpiService, InsightService, ForecastService, ImportService
│  ├─ Repositories/           # Sales, Product, Operations, Forecast, User
│  ├─ Forecasting/            # HoltWinters, SeasonalRegression, SeasonalMovingAverage, TimeSeries, Metrics
│  └─ Support/                # Money, DateRange, Stats
├─ storage/                   # Penyimpanan file cache JSON & log
├─ tests/                     # Unit test suite & test runner
├─ .env                       # Konfigurasi aktif
├─ .env.example
├─ composer.json
└─ README.md
```

---

## 🎓 Catatan Integritas Akademik
Data transaksi yang digunakan pada tahap ini adalah **data simulasi (dummy) yang dibuat realistis** dengan pola musiman, pergeseran kanal, dan distribusi Pareto kerajinan eboni khas Sulawesi Tengah. Seluruh dashboard menampilkan label *"Data simulasi untuk keperluan akademik"*. Apabila di masa mendatang data historis riil dari UMKM Sumber Urip Ebony telah terkumpul, data tersebut dapat langsung diimpor ke sistem via file CSV tanpa perlu mengubah kode sumber.
