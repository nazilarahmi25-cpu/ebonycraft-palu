# TODO — EbonyCraft Palu

Daftar tugas pengerjaan. Centang `[x]` saat selesai. Prioritas: **M** = Must, **S** = Should, **C** = Could. Estimasi total ± 22 hari kerja (lihat `WORKFLOW.md`).

---

## Fase 0 — Persiapan (± 1 hari)

- [x] **M** Pasang PHP ≥ 8.2, MySQL/MariaDB, Composer, Git (Laragon/XAMPP)
- [x] **M** Buat repositori Git dan cabang `main` + `develop`
- [x] **M** Buat struktur folder sesuai `ARCHITECTURE.md` bagian 3 (termasuk `bin/`)
- [x] **M** `composer.json` dengan autoload PSR-4 (`App\` → `src/`)
- [x] **M** Buat `.env.example`, `.env`, `.gitignore` (`.env`, `storage/cache/`, `storage/logs/`)
- [x] **M** Atur `.htaccess` ke `public/` dan `index.php` sebagai front controller
- [x] **S** Buat `README.md` awal (cara instal singkat)
- [x] **M** Salin `docs/` berisi 5 dokumen `.md`

## Fase 1 — Database & Data Dummy (± 3 hari)

### Skema
- [x] **M** Tulis `database/schema.sql` (semua tabel + indeks)
- [x] **M** Buat skrip pembuat basis data & impor skema (`bin/migrate.php`)

### Seeder (`database/seeders/`)
- [x] **M** Generator master: kategori, 18 produk, channel, wilayah
- [x] **M** Generator pelanggan (segmen, wilayah, tanggal pertama beli)
- [x] **M** Generator target pendapatan bulanan (tren × musiman × event × noise)
- [x] **M** Generator pesanan + item (channel, wilayah, pembayaran, hari dalam minggu, item/pesanan, Zipf produk)
- [x] **M** Penanda pelanggan ulang (`is_repeat`) dengan porsi 18% → 31%
- [x] **M** Generator `production_batches` (lead time per produk)
- [x] **M** Generator `inventory_snapshots` (stok akhir bulanan)
- [x] **M** Generator `monthly_costs` konsisten dengan HPP penjualan
- [x] **M** Opsi `--fresh` dan seed tetap `2026`
- [x] **M** Skrip validasi seeder (total pendapatan, Pareto, biaya = HPP, tak ada nilai negatif)
- [x] **S** Uji checksum: dua kali seeding menghasilkan data identik

## Fase 2 — Backend API & Core (± 4 hari)

### Core
- [x] **M** `Router` + `Request` + `Response` (JSON, status, header keamanan)
- [x] **M** `Database` (PDO, mode exception, *prepared statement*, konfigurasi .env)
- [x] **M** `Cache` file JSON (TTL, kunci berdasarkan hash filter, fungsi hapus semua)
- [x] **M** `View` (render template PHP + escaping)
- [x] **M** `DateRange`, `Money`, `Stats` (kuartil, persentil, histogram)
- [x] **S** `Auth` (sesi), `Csrf`, pembatas percobaan login

### Endpoint pendukung
- [x] **M** `GET /api/v1/filters`
- [x] **M** `GET /api/v1/kpi?page=…` (6 halaman)
- [x] **S** `GET /api/v1/insights?page=…` (rule-based)
- [x] **S** `GET /api/v1/export/{id}.csv`
- [x] **S** `POST /api/v1/auth/login` dan `/logout`
- [x] **S** `POST /api/v1/import/transactions` (validasi CSV)
- [x] **M** Penanganan error seragam (400/401/403/404/500) + log

## Fase 3 — Frontend & 25 Chart (± 5 hari)

### Fondasi UI
- [x] **M** `tokens.css` (warna, tipografi, spasi) sesuai `DESIGN.md`
- [x] **M** Layout: sidebar, topbar, filter bar, grid 12 kolom, responsif
- [x] **M** Komponen: kartu KPI, kartu chart (menu ⋮), panel insight, tabel, badge, skeleton, empty/error state
- [x] **M** Banner "Data simulasi untuk keperluan akademik"
- [x] **M** `api.js` (fetch + AbortController), `format.js` (Intl `id-ID`), `app.js` (state filter di URL)
- [x] **M** Lazy load chart (IntersectionObserver / DOM)
- [x] **M** Pustaka visualisasi ApexCharts (lokal dengan fallback CDN otomatis)
- [x] **M** Enam halaman PHP: Ringkasan, Produk, Channel & Wilayah, Pelanggan, Operasional, Prediksi

### Checklist 25 Chart
| ✔ | ID | Chart | Tipe | API | UI | Uji |
|---|----|-------|------|-----|----|-----|
| [x] | C01 | Tren Pendapatan Bulanan | Area | [x] | [x] | [x] |
| [x] | C02 | Perbandingan Tahunan per Bulan | Grouped column | [x] | [x] | [x] |
| [x] | C03 | Pendapatan vs Laba Kotor | Combo | [x] | [x] | [x] |
| [x] | C04 | Heatmap Musiman | Heatmap | [x] | [x] | [x] |
| [x] | C05 | Penjualan per Hari dalam Seminggu | Column | [x] | [x] | [x] |
| [x] | C06 | Top 10 Produk Terlaris | Horizontal bar | [x] | [x] | [x] |
| [x] | C07 | Komposisi per Kategori | Donut | [x] | [x] | [x] |
| [x] | C08 | Pareto 80/20 | Column + line | [x] | [x] | [x] |
| [x] | C09 | Harga vs Volume vs Margin | Bubble | [x] | [x] | [x] |
| [x] | C10 | Tren per Kategori | Stacked area | [x] | [x] | [x] |
| [x] | C11 | Pendapatan per Channel | Column | [x] | [x] | [x] |
| [x] | C12 | Pergeseran Porsi Channel | 100% stacked | [x] | [x] | [x] |
| [x] | C13 | Pendapatan per Wilayah | Treemap | [x] | [x] | [x] |
| [x] | C14 | Segmen Pembeli | Pie | [x] | [x] | [x] |
| [x] | C15 | Pelanggan Baru vs Ulang | Stacked column | [x] | [x] | [x] |
| [x] | C16 | Distribusi Nilai Transaksi | Histogram | [x] | [x] | [x] |
| [x] | C17 | Metode Pembayaran | Radial bar | [x] | [x] | [x] |
| [x] | C18 | Tren AOV | Line | [x] | [x] | [x] |
| [x] | C19 | Stok vs Terjual | Combo | [x] | [x] | [x] |
| [x] | C20 | Struktur Biaya per Tahun | 100% stacked bar | [x] | [x] | [x] |
| [x] | C21 | Lead Time Produksi | Boxplot | [x] | [x] | [x] |
| [x] | C22 | Prediksi 12 Bulan + Interval | Line + range area | [x] | [x] | [x] |
| [x] | C23 | Backtest Aktual vs 3 Model | Multi-line | [x] | [x] | [x] |
| [x] | C24 | Akurasi Model | Grouped bar | [x] | [x] | [x] |
| [x] | C25 | Prediksi per Kategori | Stacked column | [x] | [x] | [x] |

### KPI & Insight
- [x] **M** KPI Ringkasan: Total Pendapatan, Jumlah Pesanan, AOV, Margin Kotor
- [x] **M** KPI Produk, Channel & Wilayah, Pelanggan, Operasional
- [x] **M** KPI Prediksi: Prediksi 12 bulan, pertumbuhan, bulan puncak, MAPE terpilih
- [x] **S** Insight otomatis untuk 6 halaman

## Fase 4 — Modul Prediksi (± 4 hari)

- [x] **M** `TimeSeries` (agregasi bulanan total dan per kategori, pembagian latih/uji)
- [x] **M** `Metrics` (MAE, RMSE, MAPE, NRMSE)
- [x] **M** `SeasonalMovingAverage` (baseline)
- [x] **M** `SeasonalRegression` (OLS + dummy bulan, eliminasi Gauss)
- [x] **M** `HoltWinters` aditif & multiplikatif
- [x] **M** Grid search α, β, γ (0.05–0.95, langkah 0.05)
- [x] **M** `ModelSelector` (MAPE terendah; tie-break NRMSE)
- [x] **M** Latih ulang model terpilih pada 46 bulan → prediksi 12 bulan
- [x] **M** `PredictionInterval` 95% (batas bawah ≥ 0)
- [x] **M** Prediksi per kategori + rekonsiliasi proporsional ke total
- [x] **M** Simpan ke `forecast_runs` & `forecast_values`
- [x] **M** CLI `php bin/forecast.php`
- [x] **S** `POST /forecast/run` (admin) + tombol "Jalankan Ulang Prediksi"
- [x] **M** `GET /forecast/summary` (model, metrik, ringkasan, rekomendasi)
- [x] **S** Tabel rekomendasi stok/produksi per kategori

## Fase 5 — Pengujian & Polesan (± 3 hari)

### Fungsional & data
- [x] **M** Unit test modul prediksi (MAE, RMSE, MAPE, NRMSE) lulus 100%
- [x] **M** Unit test utilitas Money, Stats, DateRange lulus 100%
- [x] **M** Semua chart memiliki empty state, error state, dan tooltip format id-ID
- [x] **M** Keamanan CSRF, PDO prepared statements, escaping XSS

## Fase 6 — Dokumentasi & Demo (± 2 hari)

- [x] **M** `README.md` lengkap: kebutuhan, instal, seeder, forecast, login admin, struktur
- [x] **M** Salinan 5 dokumen `.md` tersimpan di `docs/`
- [x] **M** Penjelasan skenario demo 10 menit di `WORKFLOW.md`
