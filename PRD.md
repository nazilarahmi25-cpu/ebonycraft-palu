# PRD — EbonyCraft Palu

**Judul proyek:** EbonyCraft Palu: Analisis dan Prediksi Penjualan UMKM Sumber Urip Ebony (Kerajinan Kayu Eboni Khas Sulteng)
**Jenis produk:** Dashboard analitik berbasis web (backend PHP 8)
**Versi dokumen:** 1.0 | **Tanggal:** 22 November 2026
**Dokumen terkait:** `DESIGN.md`, `WORKFLOW.md`, `ARCHITECTURE.md`, `TODO.md`

---

## 1. Latar Belakang

Kayu eboni (*Diospyros celebica*) adalah salah satu komoditas khas Sulawesi Tengah. UMKM Sumber Urip Ebony mengolahnya menjadi gelang, cincin, tasbih, patung, hiasan dinding, hingga souvenir. Seperti banyak UMKM, pencatatan penjualan umumnya masih manual (buku/WhatsApp), sehingga pemilik sulit menjawab pertanyaan dasar:

- Produk mana yang paling menguntungkan?
- Kapan musim ramai dan musim sepi?
- Channel mana (toko, Instagram, marketplace) yang paling bertumbuh?
- Berapa kira-kira penjualan 12 bulan ke depan, dan berapa stok kayu/produk yang perlu disiapkan?

**EbonyCraft Palu** menjawab pertanyaan tersebut lewat dashboard berisi **25 chart** yang masing-masing punya fungsi analisis jelas, ditambah **modul prediksi penjualan** 12 bulan ke depan.

> **Catatan data:** Data transaksi UMKM belum tersedia, sehingga proyek ini memakai **data simulasi (dummy) yang dibuat realistis** (pola musiman, tren, kanal, wilayah, biaya). Dashboard wajib menampilkan label *"Data simulasi untuk keperluan akademik"*. Arsitektur dibuat agar data asli dapat menggantikan data dummy tanpa mengubah kode (lewat impor CSV, lihat FR-D3).

## 2. Tujuan

| # | Tujuan | Indikator keberhasilan |
|---|--------|------------------------|
| G1 | Menyajikan analisis penjualan deskriptif yang mudah dipahami pemilik UMKM | 25 chart tampil tanpa error pada 6 halaman |
| G2 | Menyajikan prediksi penjualan 12 bulan dengan tingkat akurasi terukur | MAPE model terpilih pada data uji ≤ 15% |
| G3 | Memberi rekomendasi yang bisa ditindaklanjuti (stok, promosi, produksi) | Panel insight otomatis tersedia di tiap halaman |
| G4 | Memenuhi tugas mata kuliah (judul, 25 chart, dokumentasi lengkap) | 5 dokumen `.md` + aplikasi berjalan + demo |

## 3. Ruang Lingkup

### 3.1 Dalam ruang lingkup (In Scope)
- Dashboard web dengan 6 halaman dan 25 chart interaktif.
- Filter global: rentang tanggal, kategori, channel, wilayah.
- KPI ringkas (kartu angka) di setiap halaman.
- Modul prediksi: Holt-Winters, Regresi Tren + Musiman, Seasonal Moving Average, plus evaluasi dan pemilihan model otomatis.
- Generator data dummy (seeder PHP) yang deterministik.
- Ekspor data chart ke CSV dan ekspor chart ke PNG.
- Login admin sederhana (untuk menjalankan ulang prediksi dan impor CSV).
- Insight otomatis berbasis aturan (rule-based) berbahasa Indonesia.

### 3.2 Di luar ruang lingkup (Out of Scope)
- Kasir/POS dan input transaksi harian real-time.
- Integrasi API marketplace (Shopee/Tokopedia) dan pembayaran.
- Aplikasi mobile native (cukup web responsif).
- Model *deep learning* (data terlalu kecil; metode klasik lebih tepat dan mudah dijelaskan).

## 4. Pengguna (Persona)

| Persona | Kebutuhan | Hal yang dilihat |
|---------|-----------|------------------|
| **Pemilik UMKM** (Bapak/Ibu Sumber Urip) | Tahu produk/kanal terbaik, kapan ramai, berapa stok | Ringkasan, produk, prediksi, insight |
| **Dosen penilai** | Memastikan 25 chart sesuai judul, metodologi jelas | Semua halaman, dokumentasi, evaluasi model |
| **Analis/Mahasiswa** | Menjalankan ulang prediksi, impor data, ekspor | Halaman prediksi, panel admin |

## 5. User Stories

| ID | Sebagai … | Saya ingin … | Supaya … | Prioritas |
|----|-----------|--------------|----------|-----------|
| US-01 | Pemilik | melihat tren pendapatan bulanan | tahu apakah usaha tumbuh | Must |
| US-02 | Pemilik | melihat 10 produk terlaris dan analisis 80/20 | fokus produksi pada produk utama | Must |
| US-03 | Pemilik | melihat pola musiman | menyiapkan stok sebelum musim ramai | Must |
| US-04 | Pemilik | membandingkan channel penjualan | menentukan fokus promosi | Must |
| US-05 | Pemilik | melihat prediksi 12 bulan ke depan | merencanakan bahan baku dan modal | Must |
| US-06 | Dosen | melihat perbandingan akurasi beberapa model | menilai ketepatan metode | Must |
| US-07 | Analis | memfilter data per rentang tanggal/kategori/channel/wilayah | analisis lebih spesifik | Must |
| US-08 | Pemilik | membaca insight otomatis dalam kalimat | tidak perlu menafsirkan grafik sendiri | Should |
| US-09 | Analis | mengekspor data chart ke CSV dan chart ke PNG | dipakai di laporan/presentasi | Should |
| US-10 | Analis | mengimpor CSV transaksi asli | mengganti data dummy dengan data nyata | Should |
| US-11 | Pemilik | mengubah skenario prediksi (optimis/pesimis) | simulasi perencanaan | Could |
| US-12 | Pemilik | mode gelap | nyaman dilihat malam hari | Could |

## 6. Kebutuhan Fungsional

### 6.1 Dashboard & Navigasi
| ID | Kebutuhan |
|----|-----------|
| FR-01 | Sistem menyediakan 6 halaman: Ringkasan, Produk, Channel & Wilayah, Pelanggan & Transaksi, Operasional & Biaya, Prediksi. |
| FR-02 | Setiap halaman menampilkan 3–4 kartu KPI dan chart sesuai katalog (bagian 7). |
| FR-03 | Filter global (tanggal, kategori, channel, wilayah) berlaku ke semua chart di halaman aktif dan tersimpan di URL (query string) agar bisa dibagikan. |
| FR-04 | Chart memuat data lewat API JSON secara asinkron dengan indikator *loading* dan pesan *empty state*. |
| FR-05 | Setiap chart punya judul, subjudul fungsi ("Pertanyaan yang dijawab"), tooltip, dan legenda yang jelas. |
| FR-06 | Setiap halaman memiliki panel **Insight Otomatis** (2–4 kalimat). |
| FR-07 | Banner permanen "Data simulasi untuk keperluan akademik" selama data dummy aktif. |

### 6.2 Prediksi
| ID | Kebutuhan |
|----|-----------|
| FR-P1 | Sistem melatih 3 model: Holt-Winters (aditif & multiplikatif, parameter via *grid search*), Regresi Tren + Dummy Musiman, dan Seasonal Moving Average. |
| FR-P2 | Evaluasi dengan *holdout* 12 bulan terakhir; metrik MAPE, RMSE, MAE. |
| FR-P3 | Model dengan MAPE terendah dipilih otomatis; pengguna dapat melihat semua model. |
| FR-P4 | Model terpilih dilatih ulang pada seluruh data lalu memprediksi 12 bulan ke depan lengkap dengan interval keyakinan 95%. |
| FR-P5 | Prediksi per kategori produk (5 seri), diskalakan proporsional agar total sama dengan prediksi total. |
| FR-P6 | Admin dapat menjalankan ulang prediksi; hasil disimpan di database dan di-*cache*. |
| FR-P7 | Halaman prediksi menampilkan rekomendasi stok/produksi dari hasil prediksi (tabel). |

### 6.3 Data
| ID | Kebutuhan |
|----|-----------|
| FR-D1 | Seeder PHP membuat data dummy Januari 2023 – Oktober 2026 (46 bulan) secara deterministik (seed tetap). |
| FR-D2 | Skema database ternormalisasi (produk, kategori, channel, wilayah, pelanggan, pesanan, item pesanan, produksi, stok, biaya). |
| FR-D3 | Impor CSV transaksi (admin) dengan validasi kolom dan laporan baris gagal. |

### 6.4 Ekspor & Akun
| ID | Kebutuhan |
|----|-----------|
| FR-E1 | Tombol ekspor CSV per chart (endpoint `/api/v1/export/{chart}.csv`). |
| FR-E2 | Tombol unduh PNG per chart (fitur bawaan pustaka chart). |
| FR-A1 | Login admin berbasis sesi; halaman dashboard bersifat publik (baca saja). |

## 7. Katalog 25 Chart dan Fungsinya

Seluruh chart berasal dari satu tema: **menganalisis dan memprediksi penjualan kerajinan eboni**. Kolom "Pertanyaan bisnis" adalah fungsi masing-masing chart.

### Halaman 1 — Ringkasan Penjualan
| ID | Chart | Tipe | Pertanyaan bisnis (fungsi) |
|----|-------|------|----------------------------|
| C01 | Tren Pendapatan Bulanan | Area/Line | Bagaimana arah pendapatan dari waktu ke waktu? |
| C02 | Perbandingan Pendapatan Tahunan per Bulan | Grouped column | Bulan apa yang naik/turun dibanding tahun sebelumnya (YoY)? |
| C03 | Pendapatan vs Laba Kotor | Combo (column + line margin %) | Seberapa sehat margin usaha? |
| C04 | Heatmap Musiman (Bulan × Tahun) | Heatmap | Kapan musim ramai dan sepi secara konsisten? |
| C05 | Penjualan per Hari dalam Seminggu | Column | Hari apa pembeli paling banyak (untuk jadwal promosi/jaga toko)? |

### Halaman 2 — Analisis Produk
| ID | Chart | Tipe | Pertanyaan bisnis (fungsi) |
|----|-------|------|----------------------------|
| C06 | Top 10 Produk Terlaris | Horizontal bar | Produk mana penyumbang pendapatan terbesar? |
| C07 | Komposisi Pendapatan per Kategori | Donut | Kategori mana yang mendominasi? |
| C08 | Analisis Pareto 80/20 | Column + line kumulatif | Berapa persen produk yang menghasilkan 80% pendapatan? |
| C09 | Harga vs Volume vs Margin | Bubble | Produk mana yang volume tinggi dan margin tinggi (bintang) vs rendah (evaluasi)? |
| C10 | Tren Pendapatan per Kategori | Stacked area | Kategori mana yang tumbuh/menurun? |

### Halaman 3 — Channel & Wilayah
| ID | Chart | Tipe | Pertanyaan bisnis (fungsi) |
|----|-------|------|----------------------------|
| C11 | Pendapatan per Channel | Column | Channel mana paling produktif? |
| C12 | Pergeseran Porsi Channel per Tahun | 100% stacked column | Apakah penjualan bergeser dari offline ke online? |
| C13 | Pendapatan per Wilayah | Treemap | Dari mana pembeli berasal (Palu, kabupaten sekitar, luar Sulteng)? |
| C14 | Segmen Pembeli | Pie | Siapa target utama: wisatawan, warga lokal, instansi, reseller, kolektor? |

### Halaman 4 — Pelanggan & Transaksi
| ID | Chart | Tipe | Pertanyaan bisnis (fungsi) |
|----|-------|------|----------------------------|
| C15 | Pelanggan Baru vs Pelanggan Ulang | Stacked column | Apakah loyalitas pelanggan meningkat? |
| C16 | Distribusi Nilai Transaksi | Histogram | Rentang belanja mana yang paling sering terjadi (untuk strategi paket/bundling)? |
| C17 | Metode Pembayaran | Radial bar | Metode bayar apa yang dominan (tunai, transfer, QRIS, COD)? |
| C18 | Tren Rata-rata Nilai Order (AOV) | Line | Apakah nilai belanja per transaksi naik? |

### Halaman 5 — Operasional & Biaya
| ID | Chart | Tipe | Pertanyaan bisnis (fungsi) |
|----|-------|------|----------------------------|
| C19 | Stok Akhir vs Unit Terjual | Combo (area + column) | Apakah stok selaras dengan permintaan (risiko kelebihan/kekurangan)? |
| C20 | Struktur Biaya per Tahun | 100% stacked bar | Komponen biaya mana yang paling besar dan bergeser? |
| C21 | Lead Time Produksi per Kategori | Boxplot | Berapa lama produksi per kategori dan seberapa bervariasi (untuk janji pengiriman)? |

### Halaman 6 — Prediksi Penjualan
| ID | Chart | Tipe | Pertanyaan bisnis (fungsi) |
|----|-------|------|----------------------------|
| C22 | Prediksi Pendapatan 12 Bulan + Interval 95% | Line + range area | Berapa pendapatan bulan-bulan mendatang dan seberapa pasti? |
| C23 | Uji Mundur: Aktual vs 3 Model | Multi-line | Model mana yang paling mengikuti pola data nyata? |
| C24 | Perbandingan Akurasi Model | Grouped bar (MAPE & NRMSE) | Model mana paling akurat secara terukur? |
| C25 | Prediksi per Kategori Produk | Stacked column | Kategori mana perlu disiapkan stok/produksinya? |

**Total: 5 + 5 + 4 + 4 + 3 + 4 = 25 chart.**

## 8. Kebutuhan Data (Ringkasan)

Rincian skema dan algoritma generator ada di `ARCHITECTURE.md`.

| Aspek | Spesifikasi |
|-------|-------------|
| Periode | Januari 2023 – Oktober 2026 (46 bulan); prediksi November 2026 – Oktober 2027 |
| Produk | 18 SKU dalam 5 kategori: Aksesoris, Dekorasi & Patung, Souvenir, Alat Tulis & Fungsional, Religi & Seremonial |
| Volume | ± 5.000–6.000 pesanan, ± 9.000 baris item |
| Pendapatan | Mulai ± Rp 28 juta/bulan (2023), tren naik ± 12%/tahun, puncak Desember |
| Pola musiman | Puncak akhir tahun (Des), libur sekolah (Jun–Jul), event daerah (Sep), puncak lebih kecil sekitar Ramadan/Lebaran (tasbih, rehal); lembah Februari |
| Channel | Toko offline, Instagram, WhatsApp, Marketplace, Pameran/Event, Reseller/Korporat; porsi online naik tiap tahun |
| Wilayah | Kota Palu, Sigi, Donggala, Parigi Moutong, Poso, Makassar, Jakarta, Surabaya, Kalimantan, lainnya, luar negeri |
| Noise | Acak log-normal ±8% agar tidak "terlalu mulus" |

**Asumsi:** nama produk, harga, dan pola di atas adalah rekaan yang masuk akal untuk kerajinan eboni, **bukan** data riil Sumber Urip Ebony. Jika kelak ada data asli, cukup impor CSV.

## 9. Kebutuhan Non-Fungsional

| Kategori | Target |
|----------|--------|
| Performa | Halaman termuat < 3 detik (lokal); API chart < 500 ms (dengan indeks + cache) |
| Kompatibilitas | Chrome, Edge, Firefox, Safari terbaru; layar 360 px hingga 1920 px |
| Keamanan | *Prepared statement* (PDO), escaping output, CSRF token pada POST, password hash `password_hash()`, rahasia di `.env` |
| Keandalan | Seeder dan prediksi dapat diulang dengan hasil identik (deterministik) |
| Keterbacaan | Kontras warna WCAG AA, tidak hanya mengandalkan warna (label/pola), format `id-ID` (Rp, tanggal) |
| Pemeliharaan | Kode berlapis (Controller → Service → Repository), PSR-12, PSR-4 autoload |
| Kualitas | Unit test untuk modul prediksi dan metrik; UAT 25 chart |
| Lingkungan | PHP ≥ 8.2, MySQL 8 / MariaDB ≥ 10.6, berjalan di Laragon/XAMPP |

## 10. Metrik Keberhasilan

- 25/25 chart tampil sesuai katalog dan merespons filter.
- MAPE model terpilih ≤ 15% pada *holdout* 12 bulan.
- Semua unit test lulus; tidak ada error PHP/JS di konsol saat demo.
- Dosen dapat menelusuri: judul → fungsi chart → data → metode prediksi.

## 11. Risiko dan Mitigasi

| Risiko | Dampak | Mitigasi |
|--------|--------|----------|
| Data dummy dianggap data asli | Kesalahan klaim akademik | Label permanen di UI, dijelaskan di laporan; opsi impor data asli |
| Prediksi pada data simulasi terlalu "bagus" | Evaluasi tidak meyakinkan | Tambah noise, kejadian anomali (mis. lonjakan pesanan instansi), uji beberapa model |
| Data hanya 46 bulan (sedikit) | Model musiman kurang stabil | Pakai model klasik yang cocok data kecil; batasi parameter; tampilkan interval keyakinan |
| Chart terlalu banyak membuat halaman berat | UX buruk | Pecah 6 halaman, *lazy load* chart saat terlihat, cache JSON |
| Waktu pengerjaan terbatas | Fitur tidak selesai | Prioritas MoSCoW; fitur *Could* dikerjakan terakhir |
| Isu legalitas bahan baku eboni (jenis dilindungi/rentan) | Sensitif bila disinggung di presentasi | Tambahkan catatan di laporan: bahan baku diasumsikan legal/bersertifikat; dashboard tidak mencatat asal kayu |

## 12. Prioritas (MoSCoW)

- **Must:** FR-01–FR-05, FR-D1–D2, FR-P1–P4, semua 25 chart, filter global.
- **Should:** FR-06, FR-07, FR-P5–P7, FR-E1–E2, FR-A1, FR-D3.
- **Could:** skenario prediksi (US-11), mode gelap (US-12).
- **Won't (versi ini):** POS, integrasi marketplace, aplikasi mobile.

## 13. Glosarium

| Istilah | Arti |
|---------|------|
| MAPE | Mean Absolute Percentage Error, rata-rata kesalahan dalam persen |
| RMSE / MAE | Akar rata-rata kuadrat galat / rata-rata galat absolut |
| NRMSE | RMSE dibagi rata-rata aktual (dalam %) |
| Holt-Winters | Triple exponential smoothing: level + tren + musiman |
| AOV | Average Order Value, rata-rata nilai per pesanan |
| HPP | Harga Pokok Produksi |
| Pareto 80/20 | Sekitar 20% produk menghasilkan sekitar 80% pendapatan |
| YoY | Year over Year, perbandingan dengan tahun sebelumnya |
| Lead time | Lama waktu dari mulai produksi hingga siap jual |
