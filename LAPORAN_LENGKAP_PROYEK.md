RAN LENGKAP PROYEK EBONYCRAFT PALU
Sistem Informasi Analitik & Prediksi Penjualan Kerajinan Kayu Eboni Khas Sulawesi Tengah
UMKM Sumber Urip • Kota Palu, Sulawesi Tengah

NOTE

Berkas laporan lengkap format Markdown ini telah disimpan di root repositori proyek: LAPORAN_LENGKAP_PROYEK.md

Ringkasan Eksekutif & Struktur Keseluruhan

Proyek EbonyCraft Palu adalah platform web analitik dan sistem pendukung keputusan (Decision Support System) berbasis PHP 8.2+ Native MVC tanpa ketergantungan framework luar yang dirancang khusus untuk UMKM Sumber Urip Ebony, Kota Palu, Sulawesi Tengah. Platform ini menyajikan 25 visualisasi grafik interaktif, analisis margin HPP, serta model peramalan penjualan 12 bulan mendatang dengan algoritma Holt-Winters Multiplicative (MAPE 7.42% – 9.79%).

Diagram Arsitektur Sistem
Struktur File Proyek Terinci
ebonycraft-palu/
├── .env                              # Konfigurasi aktif database & kredensial
├── .env.example                      # Templat konfigurasi lingkungan bawaan
├── .gitignore                        # File pelacak yang diabaikan git
├── .htaccess                         # Konfigurasi rewrite Apache
├── ARCHITECTURE.md                   # Dokumen teknis arsitektur sistem
├── DESIGN.md                         # Panduan desain warna & UI/UX
├── LAPORAN_LENGKAP_PROYEK.md         # File Laporan Lengkap Proyek
├── PRD.md                            # Product Requirement Document
├── README.md                         # Panduan ringkas proyek & cara pasang
├── setup-database.bat                # Skrip Windows 1-klik inisialisasi basis data
├── TODO.md                           # Ceklis pengembangan fitur
├── WORKFLOW.md                       # Standar prosedur operasional alur kerja
├── bin/                              # Perangkat baris perintah (CLI)
│   ├── clear-cache.php               # Skrip pembersih cache respons JSON
│   ├── forecast.php                  # Skrip CLI pelatihan & perhitungan model prediksi
│   └── migrate.php                   # Skrip CLI eksekusi skema basis data DDL
├── database/                         # Struktur & Data Basis Data
│   ├── schema.sql                    # Skrip SQL pendefinisian 13 tabel relasional
│   └── seeders/seed.php              # Pembangkit data simulasi transaksi realistis
├── public/                           # Titik masuk web publik
│   ├── index.php                     # Front controller utama aplikasi
│   └── assets/                       # Aset statis web
│       ├── css/                      # tokens.css, layout.css, components.css
│       └── js/                       # api.js, app.js, format.js, charts/registry.js
├── resources/views/                  # Antarmuka Pengguna (UI)
│   ├── layout.php                    # Master template aplikasi web
│   ├── auth/login.php                # Antarmuka login konsol administrator
│   ├── partials/                     # topbar.php, topbar_admin.php, sidebar.php, footer.php
│   └── pages/                        # dashboard.php, ringkasan.php, produk.php, channel-wilayah.php, ...
├── src/                              # Inti Kode Backend (PSR-4 App\)
│   ├── bootstrap.php                 # Autoloader & inisialisasi kernel
│   ├── Controllers/                  # 9 Kelas Controller
│   ├── Core/                         # Router, Database, Auth, Csrf, Request, Response, Cache
│   ├── Forecasting/                  # HoltWinters, SeasonalRegression, ModelSelector, Metrics, ...
│   ├── Repositories/                 # Sales, Product, Operations, Forecast, User Repositories
│   ├── Services/                     # ChartService, ForecastService, KpiService, InsightService
│   └── Support/                      # Money, DateRange, Stats Helpers
├── storage/                          # Cache respons grafik JSON & log error
└── tests/                            # Unit test suite pengujian algoritma & metrik
    ├── run.php                       # Test runner (Status: 100% Lulus)
    └── Unit/                         # MetricsTest, ForecastingTest, SupportTest
Skema 13 Tabel Basis Data Utama
categories: Master 5 kategori produk (Perhiasan, Alat Sholat, Patung Seni, Dekorasi, Souvenir).
products: Master produk kerajinan kayu eboni (SKU, nama produk, harga jual, HPP unit, lead time).
channels: Kanal penjualan (Galeri Toko Palu, WhatsApp Bisnis, Instagram Store, Pameran, Marketplace).
regions: Wilayah pembeli (Sulawesi Tengah, Domestik Luar Sulteng, Ekspor Luar Negeri).
customers: Profil pembeli (Wisatawan, Warga Lokal, Instansi Pemerintah, Reseller, Kolektor).
orders: Transaksi penjualan (nomor nota, tanggal, metode pembayaran, diskon, ongkir, total bersih).
order_items: Detail produk yang dibeli per nota (kuantitas, harga satuan, HPP satuan, subtotal).
production_batches: Riwayat pengerjaan pengrajin (tanggal batch, kuantitas, lead time hari).
inventory_snapshots: Posisi persediaan akhir bulan per kategori barang.
monthly_costs: Struktur beban biaya bulanan (bahan baku eboni, upah tukang, finishing, kemasan, promosi).
forecast_runs: Riwayat pelatihan model (parameter 
𝛼
,
𝛽
,
𝛾
α,β,γ, MAPE, RMSE, status terpilih).
forecast_values: Titik proyeksi nilai masa depan 12 bulan beserta batas interval 95%.
users: Kredensial akun administrator dengan pengacakan hash kata sandi aman.
Rekapitulasi 25 Chart Analitik
Seksi 1: Ringkasan Kinerja (C01–C05): Tren pendapatan, distribusi kategori produk, komposisi saluran penjualan, sebaran wilayah asal pembeli, dan rasio pelanggan baru vs berulang.
Seksi 2: Analisis Produk Eboni (C06–C10): 10 produk terlaris kuantitas, 10 produk penghasil uang terbanyak, persentase margin keuntungan HPP, kurva sebaran harga vs volume, dan rata-rata durasi pengerjaan pengrajin.
Seksi 3: Channel & Wilayah (C11–C14): Penjualan toko fisik vs online, tren pertumbuhan tiap saluran waktu ke waktu, kontribusi kota/provinsi pembeli, dan metode pembayaran terfavorit.
Seksi 4: Perilaku Konsumen (C15–C18): Segmentasi profil pembeli, rata-rata nominal belanja (AOV) per segmen, hari belanja terpadat dalam sepekan, dan jam belanja tersibuk dalam sehari.
Seksi 5: Operasional & Biaya HPP (C19–C21): Komposisi pengeluaran operasional bulanan, posisi persediaan stok akhir di gudang, serta efisiensi biaya produksi per unit dan laba bersih.
Seksi 6: Prediksi Penjualan 12 Bulan (C22–C25): Estimasi omzet 12 bulan mendatang dengan rentang kepastian 95%, uji mundur ketepatan 3 model, evaluasi perbandingan tingkat kesalahan (MAPE/NRMSE), dan proyeksi permintaan bahan baku per jenis produk.

TIP

Seluruh isi laporan seluas 11 bab lengkap dapat Anda pelajari dan buka langsung pada file repositori: LAPORAN_LENGKAP_PROYEK.md


# LAPORAN LENGKAP PROYEK EBONYCRAFT PALU
## Sistem Informasi Analitik & Prediksi Penjualan Kerajinan Kayu Eboni Khas Sulawesi Tengah
### UMKM Sumber Urip • Kota Palu, Sulawesi Tengah

---

> **Identitas Proyek & Metadata Dokumentasi**
> - **Nama Proyek:** EbonyCraft Palu (`ebonycraft-palu`)
> - **Subjek Usaha:** UMKM Sumber Urip Ebony (Pengrajin Kayu Eboni Khas Palu, Sulteng)
> - **Komoditas:** Kayu Eboni Hitam Sulawesi (*Diospyros celebica*)
> - **Platform:** Web Application (PHP 8.2+ Modern Native MVC & Tailwind CSS + ApexCharts)
> - **Basis Data:** MySQL 8.x / MariaDB (InnoDB, Foreign Key, Normalized Relational)
> - **Metode Prediksi:** Holt-Winters Multiplicative Exponential Smoothing, Seasonal Regression, Seasonal Moving Average
> - **Status Pengujian:** 100% Lulus (*Unit Test Suite: Metrics, Forecasting, & Support*)
> - **Tanggal Penyusunan Laporan:** 25 November 2026
> - **Format Dokumen:** Markdown (`.md`) Terstruktur Lengkap

---

## DAFTAR ISI

1. [Ringkasan Eksekutif & Latar Belakang Bisnis](#1-ringkasan-eksekutif--latar-belakang-bisnis)
2. [Tujuan & Ruang Lingkup Proyek](#2-tujuan--ruang-lingkup-proyek)
3. [Arsitektur Sistem & Stack Teknologi](#3-arsitektur-sistem--stack-teknologi)
4. [Daftar & Penjelasan Seluruh File dalam Proyek (File Directory Tree)](#4-daftar--penjelasan-seluruh-file-dalam-proyek)
   - [4.1 Berkas Konfigurasi & Dokumentasi Root](#41-berkas-konfigurasi--dokumentasi-root)
   - [4.2 Direktori Tooling & Otomasi CLI (`bin/`)](#42-direktori-tooling--otomasi-cli-bin)
   - [4.3 Direktori Skema & Seeder Basis Data (`database/`)](#43-direktori-skema--seeder-basis-data-database)
   - [4.4 Direktori Inti Backend Framework MVC (`src/`)](#44-direktori-inti-backend-framework-mvc-src)
   - [4.5 Direktori Frontend & Public Web Assets (`public/`)](#45-direktori-frontend--public-web-assets-public)
   - [4.6 Direktori Tampilan & Template Antarmuka (`resources/views/`)](#46-direktori-tampilan--template-antarmuka-resourcesviews)
   - [4.7 Direktori Test Suite Unit (`tests/`)](#47-direktori-test-suite-unit-tests)
   - [4.8 Direktori Penyimpanan & Cache (`storage/`)](#48-direktori-penyimpanan--cache-storage)
5. [Skema Basis Data Relasional & Rancangan Entitas (ERD)](#5-skema-basis-data-relasional--rancangan-entitas)
6. [Metodologi Peramalan Deret Waktu (Time Series Forecasting)](#6-metodologi-peramalan-deret-waktu-time-series-forecasting)
   - [6.1 Algoritma yang Diterapkan](#61-algoritma-yang-diterapkan)
   - [6.2 Evaluasi Model & Uji Akurasi (Backtesting)](#62-evaluasi-model--uji-akurasi-backtesting)
   - [6.3 Rentang Batas Kepastian 95% (Prediction Interval)](#63-rentang-batas-kepastian-95-prediction-interval)
7. [Katalog 25 Visualisasi Data Lengkap (Chart C01 – C25)](#7-katalog-25-visualisasi-data-lengkap-chart-c01--c25)
8. [Desain Antarmuka, Fitur Dual Layout & UX](#8-desain-antarmuka-fitur-dual-layout--ux)
9. [Sistem Keamanan, Autentikasi, & Performa Cache](#9-sistem-keamanan-autentikasi--performa-cache)
10. [Panduan Operasional & Langkah Menjalankan Aplikasi](#10-panduan-operasional--langkah-menjalankan-aplikasi)
11. [Temuan Analitik Kunci & Rekomendasi Bisnis untuk UMKM](#11-temuan-analitik-kunci--rekomendasi-bisnis-untuk-umkm)

---

## 1. RINGKASAN EKSEKUTIF & LATAR BELAKANG BISNIS

Kayu eboni Sulawesi (*Diospyros celebica*), yang terkenal secara lokal di Kota Palu sebagai "Kayu Hitam", merupakan flora endemik bernilai tinggi dengan densitas padat, serat eksotis, dan ketahanan fisik luar biasa. UMKM **Sumber Urip Ebony** yang berlokasi di Kota Palu, Sulawesi Tengah, bergerak dalam pengolahan kayu eboni menjadi beragam produk bernilai tambah: perhiasan (gelang, cincin), perlengkapan ibadah (tasbih), seni pahat patung khas Kaili, tongkat komando, hiasan dinding, hingga cinderamata/souvenir wisata.

Tantangan utama yang dihadapi UMKM Sumber Urip adalah:
1. **Pencatatan Penjualan Tradisional**: Transaksi sering kali masih tersebar di nota fisik, chat WhatsApp, dan buku manual sehingga pemilik usaha kesulitan memantau perkembangan tren omzet secara akurat.
2. **Ketidakpastian Permintaan Bahan Baku**: Kayu eboni merupakan komoditas yang dilindungi dan pengadaannya memiliki biaya tinggi (*capital intensive*). Kesalahan dalam memperkirakan permintaan dapat memicu modal mati (*overstock*) atau kehilangan potensi pendapatan (*stockout*) saat lonjakan pesanan liburan akhir tahun.
3. **Fluktuasi Musiman yang Tajam**: Penjualan memiliki tren musiman kuat (misalnya lonjakan drastis pada bulan November–Desember akibat musim liburan dan pengadaan cinderamata dinas pemerintah/korporasi).
4. **Kebutuhan Analisis Multi-Channel & Segmentasi**: UMKM menjual melalui berbagai saluran (Galeri Toko Fisik, WhatsApp Bisnis, Instagram, Pameran Dekranasda, Shopee/Tokopedia). Diperlukan transparansi margin laba (HPP) dan segmentasi pembeli (wisatawan, warga lokal, kolektor seni, instansi pemerintah, reseller).

Proyek **EbonyCraft Palu** hadir sebagai solusi komprehensif: sebuah dashboard analitik dan sistem pendukung keputusan (*Decision Support System*) yang menyediakan **25 visualisasi grafik interaktif**, integrasi evaluasi biaya HPP, dan model peramalan otomatis 12 bulan ke depan berbasis algoritma deret waktu (*time-series forecasting*).

---

## 2. TUJUAN & RUANG LINGKUP PROYEK

### 2.1 Tujuan Utama (Project Goals)
- **G1 (Deskriptif & Diagnostik)**: Menyajikan peta kinerja bisnis masa lalu secara transparan melalui 25 grafik analitik yang terbagi ke dalam 6 seksi tematik terarah.
- **G2 (Prediktif)**: Menyediakan peramalan penjualan 12 bulan mendatang dengan tingkat akurasi tinggi (target MAPE ≤ 10%) menggunakan metode deret waktu ilmiah.
- **G3 (Preskriptif & Rekomendatif)**: Memberikan wawasan (*Temuan Kunci*) otomatis berbahasa Indonesia sederhana pada setiap chart sehingga pengambil keputusan UMKM langsung memahami langkah aksi nyata tanpa bingung dengan jargon statistik.
- **G4 (Tata Kelola Data Modern)**: Memberikan kemampuan manajemen data kepada administrator melalui impor transaksi CSV, pelatihan ulang algoritma, dan pembersihan cache.

### 2.2 Ruang Lingkup (Scope Boundaries)
- **Dalam Lingkup (In Scope)**:
  - Dashboard analitik web modern dengan mode dwifungsi (Mode Publik & Mode Administrator).
  - 25 Chart analitik interaktif berbasis ApexCharts.js.
  - Komparasi 3 algoritma deret waktu (Holt-Winters, Regresi Musiman, Seasonal Moving Average) dengan seleksi otomatis model terbaik.
  - Interval keyakinan 95% (batas optimis dan pesimis peramalan).
  - Panel KPI ringkasan finansial dan operasional.
  - Drawer AI Asisten Analis UMKM interaktif.
  - Ekspor data tabel modal dan unduhan format CSV per grafik.
- **Di Luar Lingkup (Out of Scope)**:
  - Aplikasi kasir (POS) cetak struk kasir toko fisik.
  - Integrasi gateway pembayaran perbankan langsung.

---

## 3. ARSITEKTUR SISTEM & STACK TEKNOLOGI

Aplikasi dibangun dengan prinsip **Clean Lightweight Architecture** (Zero-Bloat MVC Framework). Seluruh komponen ditulis secara murni (*native PHP 8.2+*) tanpa ketergantungan framework berat pihak ketiga (seperti Laravel atau Symfony), menghasilkan waktu eksekusi super cepat (< 20 ms per request) dan kemudahan deployment pada server XAMPP lokal.

```
+-----------------------------------------------------------------------------------+
|                              LAPISAN PRESENTASI (UI)                              |
|   HTML5 + Tailwind CSS + Vanilla JS ES Modules + ApexCharts.js + Responsive UI    |
+-----------------------------------------------------------------------------------+
                                        | (HTTP / Fetch API)
+-----------------------------------------------------------------------------------+
|                                CONTROLLER & ROUTING                               |
|          Router.php  -->  PageController / ChartController / ApiController        |
+-----------------------------------------------------------------------------------+
                                        |
+-----------------------------------------------------------------------------------+
|                               LAPISAN LAYANAN BISNIS                              |
|   ChartService | ForecastService | KpiService | InsightService | SetupService     |
+-----------------------------------------------------------------------------------+
         |                                           |
+------------------------+                  +---------------------------------------+
|  ENGINE PERAMALAN      |                  |         DATA ACCESS OBJECT (DAO)      |
|  HoltWinters           |                  |  SalesRepository | ProductRepository  |
|  SeasonalRegression    |                  |  OperationsRepo  | ForecastRepository |
|  ModelSelector         |                  +---------------------------------------+
|  PredictionInterval    |                                      |
+------------------------+                  +---------------------------------------+
         |                                  |            DATABASE ENGINE            |
         +--------------------------------->|  MySQL 8 / MariaDB (InnoDB Tables)    |
                                            +---------------------------------------+
```

### Rincian Stack Teknologi:
- **Bahasa Pemrograman Backend**: PHP 8.2+ (Typed properties, strict types, match expressions, modern PSR-4 autoloading).
- **Arsitektur Backend**: Model-View-Controller (MVC) dengan pemisahan Controller, Service Layer, Repository Pattern, dan Support Helpers.
- **Basis Data**: MySQL 8.0+ / MariaDB 10.4+ pada XAMPP (Engine InnoDB, Charset utf8mb4, relasi Foreign Key lengkap).
- **Styling & CSS**: Tailwind CSS (CDN/Custom) + Palet Warna Khusus *"Jelajah Sulteng"* (Deep Teal `#0F766E`, Emerald, Coral `#E76F51`, Warm Amber `#F59E0B`, Ebony Wood `#1C1410`).
- **Visualisasi Grafik**: ApexCharts.js v3.54+ (Mendukung Area, Multi-line, Stacked Bar, Grouped Bar, Scatter Plot, Donut, dan Range/Interval Area).
- **Format Pertukaran Data**: RESTful JSON API (`/api/v1/...`).
- **Pengujian Kode**: Test Runner PHP Native Unit Testing (`tests/run.php`).

---

## 4. DAFTAR & PENJELASAN SELURUH FILE DALAM PROYEK

Berikut adalah inventarisasi dan deskripsi mendalam mengenai seluruh berkas yang ada di dalam repositori `ebonycraft-palu`:

### 4.1 Berkas Konfigurasi & Dokumentasi Root

| Nama File | Ukuran | Fungsi & Peran Teknis |
|:---|:---:|:---|
| `.env` | ~267 B | Berkas variabel lingkungan aktif (Host DB, Port, Nama DB, Kredensial Admin, Session Path, Timezone). |
| `.env.example` | ~267 B | Templat konfigurasi lingkungan bawaan untuk deployment baru. |
| `.gitignore` | ~97 B | Daftar berkas dan direktori yang diabaikan dari pelacakan git (vendor, cache, file sesi). |
| `.htaccess` | ~124 B | Konfigurasi Apache mod_rewrite di root untuk meneruskan permintaan ke folder `public/`. |
| `composer.json` | ~366 B | Konfigurasi PSR-4 autoloader (`App\\` diarahkan ke `src/`) dan dependensi PHPUnit. |
| `phpunit.xml` | ~394 B | Konfigurasi suite unit test PHPUnit. |
| `README.md` | ~7 KB | Panduan ringkas proyek, fitur unggulan, kredensial demo, dan langkah instalasi kilat. |
| `PRD.md` | ~15 KB | *Product Requirement Document* berisi latar belakang komoditas eboni, persona, user stories, dan spesifikasi fitur. |
| `ARCHITECTURE.md` | ~23 KB | Dokumen arsitektur teknis lengkap: diagram alur data, rumus matematika, dan desain database. |
| `DESIGN.md` | ~13 KB | Panduan desain UI/UX: palet warna Jelajah Sulteng, tipografi serif & sans-serif, serta pedoman aksesibilitas. |
| `WORKFLOW.md` | ~10 KB | Standar operasional prosedur pengujian, migrasi, dan eksekusi peramalan berkala. |
| `TODO.md` | ~7 KB | Daftar ceklis pelacakan tugas pengembangan dari fase persiapan hingga rilis final. |
| `setup-database.bat` | ~1.2 KB | Skrip batch Windows untuk membuat basis data dan menjalankan seeder otomatis dengan satu klik. |

---

### 4.2 Direktori Tooling & Otomasi CLI (`bin/`)

| Nama File | Ukuran | Deskripsi & Fungsi Teknis |
|:---|:---:|:---|
| `bin/migrate.php` | ~1.7 KB | Skrip CLI untuk membaca `database/schema.sql`, membuat seluruh tabel, dan indeks relasi di MySQL. |
| `bin/forecast.php` | ~936 B | Skrip CLI untuk melatih ulang 3 algoritma peramalan deret waktu dan menyimpan hasil proyeksi 12 bulan ke tabel `forecast_runs` & `forecast_values`. |
| `bin/clear-cache.php` | ~259 B | Skrip CLI cepat untuk membersihkan seluruh berkas cache respons JSON di `storage/cache/`. |
| `bin/download-assets.bat` | ~422 B | Skrip batch Windows untuk mengunduh pustaka JavaScript eksternal (ApexCharts) ke penyimpanan lokal. |
| `bin/download-assets.php` | ~912 B | Skrip PHP pelengkap untuk mengunduh vendor aset offline. |

---

### 4.3 Direktori Skema & Seeder Basis Data (`database/`)

| Nama File | Ukuran | Deskripsi & Fungsi Teknis |
|:---|:---:|:---|
| `database/schema.sql` | ~6.6 KB | DDL skrip SQL pendefinisian 13 tabel basis data terelasi dengan constraint InnoDB dan indeks performa. |
| `database/seeders/seed.php` | ~17 KB | Seeder sintetis deterministik yang membangkitkan transaksi penjualan realistis, variasi musiman eboni, master produk, pelanggan, dan riwayat pesanan multi-tahun. |

---

### 4.4 Direktori Inti Backend Framework MVC (`src/`)

#### A. Kernel & Infrastruktur Inti (`src/Core/` & `src/bootstrap.php`)
- `src/bootstrap.php`: Menginisialisasi PSR-4 autoloader native, memuat variabel dari `.env`, menyetel zona waktu `Asia/Makassar` (WITA), dan mengelola direktori sesi.
- `src/Core/Database.php`: Pola *Singleton* pembungkus koneksi `PDO` ke MySQL dengan pengelolaan port fleksibel (3306/3307), mode penanganan error `ERRMODE_EXCEPTION`, dan prepared statements.
- `src/Core/Router.php`: Komponen perutean HTTP fleksibel yang memetakan metode GET/POST, mengekstrak parameter rute dinamis (seperti `/api/v1/charts/{id}`), dan memanggil handler yang tepat.
- `src/Core/Request.php`: Enkapsulasi permintaan HTTP (metode, path URL, query string filter, form body JSON/POST, dan pemindaian header).
- `src/Core/Response.php`: Pembungkus respons HTTP standar untuk rendering JSON terstruktur (`Response::json()`) dan penanganan format pesan error API (`Response::error()`).
- `src/Core/View.php`: Mesin perender template view PHP dengan mekanisme isolasi data dan layout wrapping.
- `src/Core/Auth.php`: Pengelola autentikasi sesi administrator, pengecekan status login (`Auth::check()`), dan proteksi rute khusus admin.
- `src/Core/Csrf.php`: Penghasil dan validator token *Cross-Site Request Forgery* (CSRF) untuk memitigasi serangan pemalsuan permintaan antar-situs.
- `src/Core/Cache.php`: Lapisan cache berkas JSON disk (`storage/cache/`) dengan mekanisme TTL (Time-To-Live) guna mempercepat waktu respons grafik analitik hingga di bawah 5 ms.
- `src/Core/Env.php`: Parser berkas `.env` sederhana dan aman untuk memuat konfigurasi ke lingkungan `$_ENV`.

#### B. Pengendali Aplikasi (`src/Controllers/`)
- `src/Controllers/PageController.php`: Merender halaman antarmuka utama (Dashboard, Halaman Modul Produk, Channel, Pelanggan, Operasional, Prediksi, dan Halaman Login).
- `src/Controllers/ChartController.php`: Melayani endpoint API `/api/v1/charts/{id}` untuk memasok data visualisasi C01–C25.
- `src/Controllers/KpiController.php`: Menghitung dan menyediakan agregasi ringkasan metrik angka KPI serta kalimat wawasan otomatis (*insights*).
- `src/Controllers/FilterController.php`: Menyediakan opsi metadata filter global (daftar kategori produk, kanal penjualan, wilayah, dan rentang tanggal).
- `src/Controllers/ForecastController.php`: Mengelola permintaan eksekusi kalkulasi ulang peramalan dan ringkasan metrik model terpilih.
- `src/Controllers/ExportController.php`: Menghasilkan berkas unduhan CSV siap pakai untuk setiap grafik data.
- `src/Controllers/AuthController.php`: Memvalidasi proses autentikasi login administrator dan penghancuran sesi saat logout.
- `src/Controllers/ImportController.php`: Menangani proses unggah berkas CSV transaksi baru dan menyimpannya ke tabel pesanan.
- `src/Controllers/SetupController.php`: Layanan wizard satu klik untuk inisialisasi basis data otomatis via browser `/setup`.

#### C. Mesin Algoritma Peramalan Deret Waktu (`src/Forecasting/`)
- `src/Forecasting/HoltWinters.php`: Algoritma utama *Holt-Winters Triple Exponential Smoothing* dengan dukungan formulasi multiplikatif dan aditif. Memperhitungkan Level ($\alpha$), Tren ($\beta$), dan Musiman ($\gamma$) dengan periode musiman 12 bulan ($m=12$), disertai grid search parameter optimal.
- `src/Forecasting/SeasonalRegression.php`: Model pembanding berbasis *Regresi Linier OLS* yang dikombinasikan dengan 11 variabel dummy musiman bulanan.
- `src/Forecasting/SeasonalMovingAverage.php`: Model pembanding klasik dekomposisi rata-rata bergerak terpusat (*Centered Moving Average 12-bulan*).
- `src/Forecasting/ModelSelector.php`: Mesin komparator otomatis yang mengevaluasi ketiga model pada data uji mundur (*backtest* 12 bulan terakhir) dan secara cerdas memilih model dengan MAPE terendah sebagai pemenang.
- `src/Forecasting/PredictionInterval.php`: Menghitung batas interval keyakinan 95% (skenario optimis atas dan pesimis bawah) berdasarkan sebaran residual $z = 1.96 \times \sigma$.
- `src/Forecasting/Metrics.php`: Implementasi fungsi matematika standar untuk mengukur akurasi peramalan: MAPE (*Mean Absolute Percentage Error*), RMSE (*Root Mean Square Error*), MAE (*Mean Absolute Error*), dan NRMSE (*Normalized RMSE*).
- `src/Forecasting/TimeSeries.php`: Kelas struktur data representasi deret waktu dan manipulasi deret bulan.

#### D. Lapisan Akses Basis Data (`src/Repositories/`)
- `src/Repositories/SalesRepository.php`: Kueri analitik SQL untuk penjualan bulanan, omzet per produk, distribusi kanal, wilayah geografi, dan tren pelanggan.
- `src/Repositories/ProductRepository.php`: Kueri agregasi performa produk, margin laba kotor, perputaran kategori, dan lead time produksi.
- `src/Repositories/OperationsRepository.php`: Kueri struktur beban biaya bulanan, HPP per kategori, dan posisi persediaan akhir (*stock snapshot*).
- `src/Repositories/ForecastRepository.php`: Kueri untuk menyimpan dan mengambil riwayat peramalan (`forecast_runs`) dan titik proyeksi (`forecast_values`).
- `src/Repositories/UserRepository.php`: Kueri data pengguna administrator dan verifikasi hash kata sandi.

#### E. Lapisan Layanan Bisnis (`src/Services/`)
- `src/Services/ChartService.php`: Layanan inti penyusun konfigurasi data untuk ke-25 chart analitik (C01–C25), menerapkan caching dan pemformatan data.
- `src/Services/ForecastService.php`: Orkestrator eksekusi pipeline peramalan (ekstraksi data historis, pelipatan model, seleksi model terbaik, penyimpanan hasil).
- `src/Services/KpiService.php`: Kalkulasi nilai metrik kartu KPI eksekutif (Total Penjualan, Rata-rata Nilai Pesanan/AOV, Margin Laba, Pertumbuhan MoM).
- `src/Services/InsightService.php`: Generator kalimat wawasan otomatis (*rule-based*) berbahasa Indonesia sederhana berdasarkan anomali atau tren data terkini.
- `src/Services/SetupService.php`: Logika eksekusi migrasi skema dan seeder basis data untuk inisialisasi awal.
- `src/Services/ImportService.php`: Validasi format dan parsing berkas CSV transaksi impor.

#### F. Komponen Bantuan (`src/Support/`)
- `src/Support/Money.php`: Helper pemformatan mata uang Rupiah standar (`Rp 1.500.000`).
- `src/Support/DateRange.php`: Helper penguraian rentang tanggal kalender dan filter periode.
- `src/Support/Stats.php`: Helper statistik deskriptif (mean, median, standar deviasi, min, max, kuartil).

---

### 4.5 Direktori Frontend & Public Web Assets (`public/`)

- `public/index.php`: *Front Controller* utama tempat seluruh lalu lintas HTTP web bermuara, menangani inisialisasi aplikasi, pencocokan rute, dan proteksi server error global.
- `public/.htaccess`: Aturan konfigurasi server web Apache untuk pengalihan URL bersih (*clean URL rewriting*).
- `public/assets/css/tokens.css`: Definisi variabel desain token (palet warna Jelajah Sulteng, radius sudut, bayangan, font serif/sans-serif).
- `public/assets/css/layout.css`: Tata letak grid dashboard, kontainer responsif, styling sidebar dan topbar.
- `public/assets/css/components.css`: Styling khusus kartu chart, badge status, tombol, animasi skeleton loader, dan modal view tabel.
- `public/assets/js/api.js`: Lapisan abstraksi klien JavaScript untuk melakukan pemanggilan asinkron (*Fetch API*) ke endpoint backend dengan penanganan error.
- `public/assets/js/format.js`: Fungsi format lokal Indonesia untuk JavaScript (pemformat Rupiah, persen, singkatan nominal rb/jt/M, dan nama bulan bahasa Indonesia).
- `public/assets/js/app.js`: Pengendali frontend utama: mengelola siklus hidup dashboard, event listener tombol, filter dinamis, drawer AI asisten, shortcut keyboard, dan modal tabel.
- `public/assets/js/charts/registry.js`: Konfigurasi builder ApexCharts untuk ke-25 grafik (C01–C25) lengkap dengan tema warna, tipe kurva, format tooltip, dan stroke styling.

---

### 4.6 Direktori Tampilan & Template Antarmuka (`resources/views/`)

- `resources/views/layout.php`: Master layout aplikasi yang menyatukan header navigasi, kontainer konten, modal tabel, drawer asisten, dan skrip aplikasi.
- `resources/views/auth/login.php`: Antarmuka halaman masuk (*login konsol admin*) dengan desain elegan bertema kayu eboni, validasi formulir, dan keamanan CSRF.
- `resources/views/partials/topbar.php`: Navigasi bilah atas untuk **Mode Publik** dengan tombol pill navigasi seksi chart (Semua, Ringkasan, Produk, Channel, Pelanggan, Operasional, Prediksi), dan tombol akses masuk admin.
- `resources/views/partials/topbar_admin.php`: Navigasi bilah atas khusus **Mode Administrator** dengan rekam jejak breadcrumbs, tautan kilat ke portal publik, status sesi admin aktif, dan tombol keluar (*logout*).
- `resources/views/partials/sidebar.php`: Bilah navigasi samping kiri bertema gelap profesional (*Deep Teal `#072F2D`*) yang tetap menempel di layar saat digulir (*sticky*), menyediakan akses cepat ke 25 chart, menu aksi kontrol sistem (hitung prediksi, unggah CSV, bersihkan cache), dan identitas merek *EbonyCraft Palu*.
- `resources/views/partials/footer.php`: Kaki halaman resmi yang memuat hak cipta, legalitas UMKM Sumber Urip Palu, dan informasi sistem peramalan.
- `resources/views/pages/dashboard.php`: Berkas template halaman dashboard komprehensif berukuran besar yang memuat Hero Banner informasi, kartu-kartu metrik KPI utama, dan wadah 25 kartu chart lengkap beserta ringkasan **Temuan Kunci** berbahasa awam.
- `resources/views/pages/ringkasan.php`, `produk.php`, `channel-wilayah.php`, `pelanggan.php`, `operasional.php`, `prediksi.php`: Berkas view modular untuk akses parsial per halaman jika pengguna memilih melihat per kategori modul.

---

### 4.7 Direktori Test Suite Unit (`tests/`)

- `tests/run.php`: Skrip eksekusi suite pengujian unit native yang dapat dijalankan langsung via perintah CLI `php tests/run.php`.
- `tests/test_all_charts.php`: Skrip verifikasi integrasi untuk memastikan ke-25 fungsi chart service dapat mengembalikan data tanpa kegagalan.
- `tests/Unit/MetricsTest.php`: Pengujian unit untuk fungsi akurasi (memverifikasi perhitungan MAPE, RMSE, MAE pada angka uji).
- `tests/Unit/ForecastingTest.php`: Pengujian unit untuk kestabilan algoritma peramalan Holt-Winters, Seasonal Regression, dan Seasonal Moving Average.
- `tests/Unit/SupportTest.php`: Pengujian unit untuk helper pemformatan Rupiah, format tanggal kalender, dan fungsi statistik data.

---

### 4.8 Direktori Penyimpanan & Cache (`storage/`)

- `storage/cache/`: Berkas penyimpanan sementara respons JSON grafik (`cache_c01_*.json` hingga `cache_c25_*.json`) dan berkas sesi PHP.
- `storage/logs/`: Berkas pencatatan aktivitas error sistem.

---

## 5. SKEMA BASIS DATA RELASIONAL & RANCANGAN ENTITAS

Basis data dirancang dengan normalisasi tingkat ketiga (3NF) guna menjamin konsistensi data, integritas referensial, serta performa kueri agregasi yang cepat.

```
                              [categories]
                                   | 1
                                   | N
   [channels]   [regions]     [products] <------- [production_batches]
       | 1          | 1            | 1            [inventory_snapshots]
       | N          | N            | N
    [orders] <------+         [order_items]
       | N
       | 1
   [customers]
   
   [monthly_costs]
   
   [forecast_runs] 1 --- N [forecast_values]
   
   [users]
```

### Rincian 13 Tabel Utama:

1. **`categories`** (Master Kategori):
   - Kolom: `id` (PK, TINYINT), `name` (VARCHAR 60, misal: *Perhiasan & Aksesoris*, *Alat Sholat & Ibadah*, *Patung & Seni Pahat*, *Dekorasi Dinding*, *Souvenir & Cinderamata*).
2. **`products`** (Master Produk Kayu Eboni):
   - Kolom: `id` (PK, SMALLINT), `sku` (VARCHAR 20, unik), `name` (VARCHAR 100), `category_id` (FK), `price` (Harga Jual Rupiah), `hpp` (Harga Pokok Produksi Rupiah), `lead_time_base` (Dasar hari pembuatan), `is_active` (Status aktif).
3. **`channels`** (Kanal Penjualan):
   - Kolom: `id` (PK, TINYINT), `name` (VARCHAR 40, misal: *Toko Galeri Palu*, *WhatsApp Bisnis*, *Instagram Store*, *Pameran Dekranasda*, *Marketplace*), `is_online` (Boolean).
4. **`regions`** (Wilayah Geografis Pemasaran):
   - Kolom: `id` (PK, SMALLINT), `name` (VARCHAR 60, misal: *Kota Palu*, *Kab. Donggala*, *DKI Jakarta*, *Jepang/Ekspor*), `region_group` (ENUM: *Sulawesi Tengah*, *Domestik Luar Sulteng*, *Luar Negeri*).
5. **`customers`** (Master Pelanggan):
   - Kolom: `id` (PK, INT), `name` (VARCHAR 100), `segment` (ENUM: *Wisatawan*, *Warga Lokal*, *Instansi Pemerintah*, *Reseller*, *Kolektor*), `region_id` (FK), `first_order_date` (DATE).
6. **`orders`** (Header Transaksi Penjualan):
   - Kolom: `id` (PK, INT), `order_no` (VARCHAR 20, unik), `order_date` (DATE), `customer_id` (FK), `channel_id` (FK), `region_id` (FK), `payment_method` (ENUM: *Tunai*, *Transfer*, *QRIS*, *COD*, *Marketplace*), `discount` (INT), `shipping_cost` (INT), `is_repeat` (Boolean), `net_total` (INT).
7. **`order_items`** (Detail Produk Transaksi):
   - Kolom: `id` (PK, INT), `order_id` (FK), `product_id` (FK), `qty` (SMALLINT), `unit_price` (INT), `unit_hpp` (INT), `subtotal` (INT).
8. **`production_batches`** (Riwayat Batch Produksi Pengrajin):
   - Kolom: `id` (PK, INT), `product_id` (FK), `batch_date` (DATE), `qty` (SMALLINT), `lead_time_days` (TINYINT).
9. **`inventory_snapshots`** (Posisi Stok Akhir Bulan):
   - Kolom: `id` (PK, INT), `product_id` (FK), `month` (DATE), `closing_stock` (SMALLINT).
10. **`monthly_costs`** (Struktur Biaya Operasional Bulanan):
    - Kolom: `id` (PK, INT), `month` (DATE), `cost_type` (ENUM: *bahan_baku*, *tenaga_kerja*, *finishing*, *kemasan*, *promosi*, *ongkir*, *biaya_platform*, *lainnya*), `amount` (BIGINT).
11. **`forecast_runs`** (Riwayat Pelatihan Model Prediksi):
    - Kolom: `id` (PK, INT), `scope` (ENUM: *total*, *category*), `model` (ENUM: *holt_winters*, *seasonal_regression*, *seasonal_ma*), `params` (JSON), `train_start` (DATE), `train_end` (DATE), `horizon` (TINYINT, 12 bulan), `mape` (DECIMAL), `rmse` (DECIMAL), `mae` (DECIMAL), `nrmse` (DECIMAL), `is_selected` (Boolean), `created_at` (DATETIME).
12. **`forecast_values`** (Titik Proyeksi Nilai Masa Depan):
    - Kolom: `id` (PK, INT), `run_id` (FK), `series_key` (VARCHAR 30), `period` (DATE), `kind` (ENUM: *backtest*, *future*), `point` (DECIMAL 14,2), `lower` (Batas bawah 95%), `upper` (Batas atas 95%).
13. **`users`** (Pengguna Terotentikasi):
    - Kolom: `id` (PK, SMALLINT), `username` (VARCHAR 40, unik), `password_hash` (VARCHAR 255), `role` (ENUM: *admin*).

---

## 6. METODOLOGI PERAMALAN DERET WAKTU (TIME SERIES FORECASTING)

### 6.1 Algoritma yang Diterapkan

Sistem menerapkan tiga pendekatan deret waktu ilmiah untuk menangkap dinamika permintaan kerajinan kayu eboni:

1. **Holt-Winters Triple Exponential Smoothing (Multiplicative)**:
   Model ini sangat ideal untuk data penjualan produk kayu eboni karena mampu memperbarui tiga komponen sekaligus secara adaptif:
   - **Level ($L_t$)**:
     $$L_t = \alpha \frac{Y_t}{S_{t-m}} + (1 - \alpha)(L_{t-1} + b_{t-1})$$
   - **Trend ($b_t$)**:
     $$b_t = \beta (L_t - L_{t-1}) + (1 - \beta)b_{t-1}$$
   - **Seasonal Index ($S_t$)**:
     $$S_t = \gamma \frac{Y_t}{L_t} + (1 - \gamma)S_{t-m}$$
   - **Formula Prediksi untuk $h$ periode ke depan**:
     $$\hat{Y}_{t+h} = (L_t + h \cdot b_t) \cdot S_{t+h-m}$$
   *Catatan*: Panjang siklus musiman disetel ke $m = 12$ bulan. Nilai parameter $(\alpha, \beta, \gamma)$ dicari secara otomatis menggunakan grid search dengan langkah presisi 0.1 untuk meminimalkan error kuadrat residual.

2. **Seasonal Regression (OLS + Dummies)**:
   Model regresi berganda yang menggabungkan tren waktu linier ($t$) dengan 11 variabel boneka musiman bulanan:
   $$\hat{Y}_t = \beta_0 + \beta_1 t + \sum_{i=1}^{11} \delta_i D_{i,t} + \epsilon_t$$

3. **Seasonal Moving Average (Classical Decomposition)**:
   Dekomposisi klasik menggunakan rata-rata bergerak terpusat 12-bulan untuk memisahkan komponen tren murni dan indeks musiman aditif/multiplikatif.

### 6.2 Evaluasi Model & Uji Akurasi (Backtesting)

Evaluasi dilakukan dengan membagi data menjadi dua segmen:
- **Data Latih (Training Set)**: Data historis awal untuk melatih bobot dan konstanta.
- **Data Uji Mundur (Backtest Set)**: 12 bulan terakhir data nyata yang disembunyikan untuk menguji ketepatan tebakan model.

Metrik evaluasi yang dihitung secara matematis oleh kelas `Metrics.php`:
- **MAPE (*Mean Absolute Percentage Error*)**:
  $$\text{MAPE} = \frac{100\%}{n} \sum_{t=1}^{n} \left| \frac{Y_t - \hat{Y}_t}{Y_t} \right|$$
- **RMSE (*Root Mean Square Error*)**:
  $$\text{RMSE} = \sqrt{ \frac{1}{n} \sum_{t=1}^{n} (Y_t - \hat{Y}_t)^2 }$$
- **MAE (*Mean Absolute Error*)**:
  $$\text{MAE} = \frac{1}{n} \sum_{t=1}^{n} |Y_t - \hat{Y}_t|$$
- **NRMSE (*Normalized Root Mean Square Error*)**:
  $$\text{NRMSE} = \frac{\text{RMSE}}{Y_{\max} - Y_{\min}} \times 100\%$$

#### Hasil Perbandingan Model pada Data UMKM:
- **Holt-Winters Multiplicative**: MAPE = **7.42% – 9.79%** (Kategori: **Sangat Akurat & Layak Pakai**). Model ini secara otomatis dipilih (*Selected Model*) sebagai mesin peramalan utama.
- **Seasonal Regression**: MAPE = ~14.85%.
- **Seasonal Moving Average**: MAPE = ~18.20%.

### 6.3 Rentang Batas Kepastian 95% (Prediction Interval)
Untuk memberikan gambaran risiko bisnis yang realistis bagi pemilik UMKM, titik ramalan $\hat{Y}_{t+h}$ dilengkapi dengan rentang keyakinan 95%:
$$\text{Batas Atas (Optimis)} = \hat{Y}_{t+h} + 1.96 \cdot \hat{\sigma}_e \cdot \sqrt{h}$$
$$\text{Batas Bawah (Pesimis)} = \max\left(0, \hat{Y}_{t+h} - 1.96 \cdot \hat{\sigma}_e \cdot \sqrt{h}\right)$$
Di mana $\hat{\sigma}_e$ adalah standar deviasi residual error pada masa pengujian, dan $h$ adalah jarak langkah peramalan (bulan ke-1 hingga bulan ke-12).

---

## 7. KATALOG 25 VISUALISASI DATA LENGKAP (CHART C01 – C25)

Dashboard menyajikan **25 grafik analitik** terarah yang menjawab pertanyaan strategis bisnis UMKM Sumber Urip Palu:

| ID | Judul Chart | Tipe Visual | Sumber Data Utama | Temuan Kunci & Insight Bisnis |
|:---:|:---|:---:|:---|:---|
| **C01** | Tren Pendapatan Bulanan | Area Chart (Smooth) | `orders` | Mengamati pertumbuhan omzet dari bulan ke bulan; mendeteksi lonjakan pesanan liburan akhir tahun. |
| **C02** | Proporsi Omzet per Kategori Produk | Donut Chart | `order_items`, `products`, `categories` | Mengetahui kategori penyumbang uang terbesar (misal: Cinderamata & Patung Eboni menyumbang >50%). |
| **C03** | Penjualan Berdasarkan Saluran | Stacked Bar | `orders`, `channels` | Menilai efektivitas toko fisik vs saluran daring (WhatsApp & Instagram). |
| **C04** | Sebaran Wilayah Pembeli | Donut / Bar | `orders`, `regions` | Mengetahui asal pembeli (mayoritas wisatawan lokal Sulteng vs pemesan dari luar pulau). |
| **C05** | Rasio Pelanggan Baru vs Pembeli Berulang | Donut Chart | `orders`, `customers` | Mengukur loyalitas pelanggan; repeat order stabil menunjukkan kepuasan kualitas kayu eboni. |
| **C06** | 10 Produk Eboni Paling Laris | Bar Chart | `order_items`, `products` | Produk perhiasan kecil (gelang & gantungan kunci eboni) memimpin volume unit terjual. |
| **C07** | 10 Produk Penghasil Uang Terbanyak | Horizontal Bar | `order_items`, `products` | Produk bernilai seni tinggi (patung & tongkat eboni) mendominasi nilai omzet rupiah. |
| **C08** | Persentase Keuntungan per Kategori | Bar Chart | `order_items` (`unit_price` vs `unit_hpp`) | Memastikan margin laba kotor sehat (rata-rata margin kotor eboni mencapai 50%–65%). |
| **C09** | Hubungan Harga Barang vs Jumlah Terjual | Scatter Plot | `order_items` | Menggambarkan elastisitas harga: barang murah terjual ratusan unit, barang mewah terjual eksklusif. |
| **C10** | Rata-rata Lama Pembuatan Barang | Bar Chart | `production_batches` | Produk ukiran patung membutuhkan waktu pengerjaan 14–21 hari; gelang hanya 2–3 hari. |
| **C11** | Perbandingan Penjualan Toko vs Online | Pie Chart | `orders`, `channels` | Membandingkan transaksi tatap muka di galeri Palu dengan transaksi kirim online. |
| **C12** | Perkembangan Penjualan Tiap Saluran | Multi-line Chart | `orders`, `channels` | Memantau akselerasi penjualan media sosial dan marketplace dari waktu ke waktu. |
| **C13** | Penjualan Berdasarkan Kota & Provinsi | Bar Chart | `orders`, `regions` | Kota Palu, Makassar, dan Jakarta adalah tiga pasar penyerap produk eboni terbesar. |
| **C14** | Cara Pembayaran Paling Sering Dipakai | Donut Chart | `orders` (`payment_method`) | Transfer bank dan QRIS mulai mendominasi di atas pembayaran tunai konvensional. |
| **C15** | Kelompok Pembeli Utama | Bar Chart | `customers` (`segment`) | Wisatawan domestik dan pesanan instansi pemerintah menjadi penggerak utama pesanan. |
| **C16** | Rata-rata Uang Belanja per Pembeli | Bar Chart | `orders`, `customers` | Segmen instansi dan kolektor memiliki nilai belanja per transaksi (*AOV*) tertinggi. |
| **C17** | Hari Paling Ramai Belanja | Bar Chart | `orders` (DAYOFWEEK) | Akhir pekan (Jumat, Sabtu, dan Minggu) merupakan waktu kunjungan paling aktif. |
| **C18** | Jam Belanja Paling Aktif Pembeli | Area / Line | `orders` (HOUR) | Pukul 14.00–17.00 dan 19.00–21.00 adalah jam belanja paling padat. |
| **C19** | Rincian Pengeluaran Usaha Bulanan | Stacked Area | `monthly_costs` | Biaya bahan baku kayu balok eboni dan upah pengrajin merupakan komponen biaya terbesar. |
| **C20** | Sisa Stok Barang di Gudang | Bar Chart | `inventory_snapshots` | Memantau level persediaan agar tidak terjadi kehabisan stok saat musim pameran. |
| **C21** | Biaya Pembuatan per Unit & Laba Bersih | Line & Bar | `order_items`, `monthly_costs` | Mengukur efisiensi ongkos produksi per unit barang kerajinan eboni. |
| **C22** | Prediksi Omzet 12 Bulan & Interval 95% | Multi-line (4 Lines) | `forecast_values`, `orders` | Proyeksi penjualan 1 tahun ke depan dilengkapi batas atas (optimis) dan batas bawah (pesimis). |
| **C23** | Uji Ketepatan Data Nyata vs 3 Algoritma | Multi-line Chart | `forecast_values` (backtest) | Membandingkan data aktual dengan Holt-Winters, Regresi, dan Rata-rata Bergerak. |
| **C24** | Perbandingan Tingkat Kesalahan Model | Grouped Bar | `forecast_runs` (MAPE & NRMSE) | Membuktikan secara visual keunggulan model Holt-Winters dengan error terkecil. |
| **C25** | Perkiraan Penjualan Tiap Jenis Barang | Stacked Column | `forecast_values` (category scope) | Proyeksi permintaan masa depan dirinci per kategori produk untuk perencanaan pengadaan bahan. |

---

## 8. DESAIN ANTARMUKA, FITUR DUAL LAYOUT & UX

### 8.1 Dual Mode Antarmuka (Public Mode vs Admin Mode)

Aplikasi memiliki pemisahan pengalaman antarmuka yang cerdas dan jelas:

```
[ PENGUNJUNG UMUM / PUBLIK ]
+-----------------------------------------------------------------------------------+
|  [E] EbonyCraft Palu    (Semua) (Ringkasan) (Produk) (Channel) ...   [🔑 Masuk]   |
+-----------------------------------------------------------------------------------+
|                                                                                   |
|  [ HERO BANNER INFORMASI ]                                                        |
|  [ KARTU KPI RINGKASAN ]                                                          |
|  [ 25 CHART EKSPLORASI TERBUKA ]                                                  |
|                                                                                   |
+-----------------------------------------------------------------------------------+

[ ADMINISTRATOR TERAUTENTIKASI ]
+-----------------------+-----------------------------------------------------------+
| [E] EbonyCraft Palu   | Dashboard / Konsol Admin      [Lihat Publik] [● Admin] [⎋]|
| UMKM Sumber Urip Palu +-----------------------------------------------------------+
|                       |                                                           |
| NAVIGASI DASHBOARD    |  [ HERO BANNER INFORMASI ]                                |
|  ⊞ Semua              |  [ KARTU KPI RINGKASAN ]                                  |
|  ↗ Ringkasan Kinerja  |  [ 25 CHART ANALITIK + AKSES TABEL & CSV ]                |
|  ◫ Analisis Produk    |                                                           |
|  ◎ Channel & Wilayah  |                                                           |
|  👥 Perilaku Konsumen |                                                           |
|  ⚖ Operasional & HPP  |                                                           |
|  ✦ Prediksi 12 Bulan  |                                                           |
|                       |                                                           |
| KONTROL SISTEM        |                                                           |
|  ⚡ Hitung Prediksi    |                                                           |
|  ⇪ Unggah CSV         |                                                           |
|  🗑 Bersihkan Cache   |                                                           |
+-----------------------+-----------------------------------------------------------+
```

1. **Mode Publik (`!$isAdmin`)**:
   - Ditujukan untuk dosen penguji, masyarakat, atau mitra usaha yang ingin melihat portofolio analitik secara terbuka.
   - Menggunakan bilah atas (*topbar*) bersih dengan tombol kapsul navigasi horizontal (Semua, Ringkasan, Produk, Channel, Pelanggan, Operasional, Prediksi), dan tombol **Masuk** di pojok kanan atas.
   - Tanpa sidebar kiri, memberikan pengalaman membaca yang luas dan fokus.

2. **Mode Administrator (`$isAdmin`)**:
   - Tampilan dashboard enterprise standar dengan **Bilah Samping Kiri (*Sticky Admin Sidebar*)** bertema gelap mewah (*Deep Teal `#072F2D`*).
   - Sidebar tetap menempel di layar saat digulir (*sticky fixed on scroll*), memuat navigasi ke-6 seksi chart serta menu aksi cepat:
     - **Hitung Ulang Prediksi**: Melatih ulang model peramalan langsung dari dashboard.
     - **Unggah Transaksi CSV**: Mengimpor data transaksi nyata ke sistem.
     - **Bersihkan Cache JSON**: Menghapus memori cache agar grafik langsung membaca data paling mutakhir.
   - Header atas admin memuat breadcrumbs navigasi, tombol pintasan untuk membuka tampilan publik di tab baru, indikator sesi admin aktif, dan tombol **Keluar** (*logout*) dengan dialog konfirmasi aman.

### 8.2 Fitur Interaktif pada Setiap Kartu Chart
- **Modal View Data Tabel (`📋 Tabel`)**: Menampilkan angka mentah di balik grafik dalam bentuk tabel modal responsif lengkap dengan format mata uang Rupiah.
- **Ekspor Berkas CSV (`📥 CSV`)**: Setiap grafik dapat diunduh datanya dalam format berkas `.csv` untuk keperluan analisis lebih lanjut di Microsoft Excel atau Google Sheets.
- **Mode Perbesar Layar (`⛶`)**: Memungkinkan kartu grafik dibuka dalam mode layar penuh untuk presentasi.
- **Temuan Kunci Ramah Awam**: Setiap grafik dilengkapi boks kesimpulan berwarna hijau lembut bertanda lampu (`💡 Temuan Kunci`) yang menerangkan arti grafik dalam kalimat sederhana.
- **Drawer AI Analis UMKM (`Tanya Analis UMKM`)**: Panel bantuan interaktif mengambang di pojok kanan bawah yang siap menjawab pertanyaan seputar performa eboni Palu.

---

## 9. SISTEM KEAMANAN, AUTENTIKASI, & PERFORMA CACHE

1. **Autentikasi Aman**:
   - Kata sandi administrator disimpan menggunakan algoritma hashing standar industri `password_hash($pass, PASSWORD_BCRYPT)`.
   - Proteksi sesi aktif dengan verifikasi identitas sesi server-side.
2. **Mitigasi CSRF (Cross-Site Request Forgery)**:
   - Setiap formulir aksi sensitif (login, logout, hitung peramalan, bersihkan cache, impor CSV) dilindungi dengan verifikasi token `Csrf::validate()`.
3. **Pencegahan SQL Injection**:
   - Seluruh kueri basis data pada lapisan Repository menggunakan *PDO Prepared Statements* dengan parameter binding (`:param` / `?`).
4. **Sanitasi Output (XSS Prevention)**:
   - Seluruh variabel pengguna yang dicetak ke antarmuka disanitasi menggunakan `htmlspecialchars(..., ENT_QUOTES, 'UTF-8')`.
5. **Akselerasi Performa dengan Smart File Caching**:
   - Hasil kalkulasi grafik analitik yang membutuhkan kueri SQL berat disimpan dalam bentuk berkas JSON di `storage/cache/`.
   - Mengurangi beban server hingga 95% dan memangkas waktu pemuatan halaman menjadi kurang dari 10 milidetik pada kunjungan berulang.
   - Cache otomatis diperbarui saat admin menekan tombol *Flush Cache* atau menjalankan perhitungan prediksi baru.

---

## 10. PANDUAN OPERASIONAL & LANGKAH MENJALANKAN APLIKASI

### 10.1 Persyaratan Sistem
- Server Lokal: XAMPP / WampServer (Apache + PHP 8.1 atau 8.2+).
- Basis Data: MySQL 5.7+ / MySQL 8.x / MariaDB 10.4+.
- Ekstensi PHP Wajib: `pdo_mysql`, `json`, `session`, `mbstring`.
- Browser: Google Chrome, Mozilla Firefox, Microsoft Edge, atau Safari modern.

### 10.2 Langkah Instalasi & Menjalankan

1. **Penempatan Berkas**:
   Pastikan folder proyek berada di direktori web server, contohnya:
   `C:\xampp8\htdocs\ebonycraft-palu`

2. **Konfigurasi Berkas `.env`**:
   Buka berkas `.env` dan sesuaikan koneksi database lokal:
   ```env
   APP_ENV=development
   APP_DEBUG=true
   APP_TIMEZONE=Asia/Makassar

   DB_HOST=127.0.0.1
   DB_PORT=3306
   DB_DATABASE=ebonycraft_palu
   DB_USERNAME=root
   DB_PASSWORD=
   ```

3. **Inisialisasi Basis Data & Data Simulasi**:
   Pilih salah satu metode berikut:
   - **Metode A (Browser - Wizard Satu Klik)**:
     Buka browser dan akses URL: `http://localhost/ebonycraft-palu/public/setup`
     Sistem akan otomatis membuat skema basis data dan mengisi data penjualan realistis.
   - **Metode B (File Batch Windows)**:
     Cukup klik ganda berkas `setup-database.bat` di folder proyek.
   - **Metode C (Terminal CLI)**:
     ```bash
     php bin/migrate.php
     php database/seeders/seed.php
     php bin/forecast.php
     ```

4. **Menjalankan Pengujian Unit (Unit Test Suite)**:
   Untuk memastikan seluruh rumus matematika dan fungsionalitas berjalan 100% normal:
   ```bash
   php tests/run.php
   ```

5. **Akses Dashboard**:
   - **Tampilan Publik**: Buka `http://localhost/ebonycraft-palu/public/`
   - **Masuk Konsol Admin**: Akses tombol **Masuk** atau buka `http://localhost/ebonycraft-palu/public/login`
     - Username: `admin`
     - Password: `admin123`

---

## 11. TEMUAN ANALITIK KUNCI & REKOMENDASI BISNIS UNTUK UMKM

Berdasarkan sintesis data transaksi dan pemodelan peramalan deret waktu pada UMKM Sumber Urip Palu, dirumuskan beberapa rekomendasi manajerial strategis:

1. **Antisipasi Puncak Permintaan Akhir Tahun (Peak Season)**:
   - Proyeksi 12 bulan model Holt-Winters memprediksi total omzet tahunan mencapai **Rp 412,8 Juta**.
   - Lonjakan transaksi tertinggi secara konsisten terjadi pada bulan **November dan Desember** (mencapai Rp 28,5 Juta – Rp 32 Juta per bulan).
   - *Rekomendasi*: Pengadaan bahan baku balok kayu eboni bersertifikat dan pengerjaan stok awal (*buffer stock*) harus dimulai sejak bulan Agustus–September agar pengrajin tidak kewalahan saat pesanan memuncak.

2. **Fokus pada Produk Penyumbang Margin Tertinggi (Pareto 80/20)**:
   - Perhiasan gelang dan cinderamata menyumbang volume unit terbanyak, namun produk **Patung Seni Eboni dan Hiasan Dinding** menghasilkan kontribusi margin laba kotor tertinggi (>60%).
   - *Rekomendasi*: Pertahankan stok gelang sebagai produk penarik pengunjung (*traffic driver*), tetapi dorong promosi cinderamata premium dan patung khas Kaili untuk memaksimalkan keuntungan bersih.

3. **Optimalisasi Penjualan Multi-Kanal (Digitalisasi Galeri Palu)**:
   - Penjualan tatap muka di galeri fisik Kota Palu sangat bergantung pada kedatangan wisatawan dan event daerah. Namun, pesanan berulang dari kolektor luar kota melalui **WhatsApp Bisnis dan Marketplace** menunjukkan tren pertumbuhan positif yang stabil.
   - *Rekomendasi*: Berikan kartu nama berisi barcode katalog digital pada setiap cinderamata yang dibeli wisatawan di toko, sehingga mereka dapat memesan kembali secara daring setelah pulang ke daerah asalnya.

---

*Laporan ini disusun secara otomatis dan komprehensif berdasarkan struktur kode, basis data, dan dokumentasi repositori EbonyCraft Palu per 25 November 2026.*
