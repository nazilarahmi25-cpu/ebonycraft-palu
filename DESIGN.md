# DESIGN — EbonyCraft Palu

Dokumen desain antarmuka (UI/UX) dashboard. Acuan fungsi chart ada di `PRD.md`; implementasi teknis ada di `ARCHITECTURE.md`.

---

## 1. Prinsip Desain

1. **Hangat, berkelas, dan lokal.** Palet terinspirasi kayu eboni (hitam kecokelatan), serat kayu, dan emas hangat khas kerajinan.
2. **Satu chart = satu pertanyaan.** Setiap kartu chart menampilkan judul dan subjudul "pertanyaan yang dijawab".
3. **Data dulu, dekorasi belakangan.** Ornamen minimal; ruang putih cukup; warna dipakai bermakna.
4. **Mudah dibaca pemilik UMKM.** Bahasa Indonesia sederhana, angka dalam format Rupiah ringkas (Rp 42,5 jt).
5. **Responsif dan aksesibel.** Nyaman di laptop dosen, proyektor, dan ponsel.

## 2. Design Tokens

### 2.1 Warna

| Token | Hex | Pemakaian |
|-------|-----|-----------|
| `--ebony-900` | `#1C1410` | Sidebar, teks judul gelap |
| `--ebony-700` | `#3B2A20` | Hover sidebar, header tabel |
| `--mahogany` | `#7A4B2A` | Aksen sekunder, tombol sekunder |
| `--amber` | `#C8892B` | Aksen utama (tombol, item aktif, garis tren utama) |
| `--sand` | `#E8D8BD` | Border halus, latar badge |
| `--cream` | `#FAF6EE` | Latar halaman |
| `--surface` | `#FFFFFF` | Latar kartu |
| `--text` | `#2A211B` | Teks utama |
| `--muted` | `#7C6F64` | Teks sekunder |
| `--success` | `#3F6B4F` | Naik / positif |
| `--danger` | `#B3402E` | Turun / peringatan |
| `--info` | `#2F6F8F` | Informasi, garis prediksi |

**Palet chart (kategorikal, 8 warna, aman untuk buta warna ringan):**
`#C8892B` · `#7A4B2A` · `#2F6F8F` · `#3F6B4F` · `#B3402E` · `#8C6BB1` · `#D9B26F` · `#5B5B5B`

**Konvensi:** aktual = garis solid amber; prediksi = garis putus-putus biru (`--info`) dengan area interval transparan 15%.

**Kontras:** teks `--text` di atas `--cream`/`--surface` ≥ 12:1; teks putih di atas `--ebony-900` ≥ 15:1; tombol amber memakai teks `--ebony-900`.

### 2.2 Tipografi

| Peran | Font | Ukuran / bobot |
|-------|------|----------------|
| Brand & judul halaman | *Playfair Display* (fallback `Georgia, serif`) | 28 px / 700 |
| Judul kartu | *Inter* (fallback `system-ui, sans-serif`) | 16 px / 600 |
| Subjudul kartu | Inter | 13 px / 400, warna `--muted` |
| Angka KPI | Inter | 28 px / 700, `font-variant-numeric: tabular-nums` |
| Isi/tabel | Inter | 14 px / 400 |

### 2.3 Spasi, Radius, Bayangan
- Skala spasi: 4 · 8 · 12 · 16 · 24 · 32 px.
- Radius kartu 14 px; tombol/input 10 px.
- Bayangan kartu: `0 1px 2px rgba(28,20,16,.06), 0 4px 16px rgba(28,20,16,.05)`.
- Border kartu: `1px solid var(--sand)`.

### 2.4 Format Angka & Tanggal (locale `id-ID`)
| Jenis | Contoh |
|-------|--------|
| Rupiah penuh | Rp 42.510.000 |
| Rupiah ringkas | Rp 42,5 jt · Rp 1,7 M |
| Persen | 12,4% (koma desimal) |
| Bulan | Jan 2026, Des 2025 |
| Tanggal | 22 Nov 2026 |

## 3. Layout

### 3.1 Kerangka Halaman
```
┌──────────────┬────────────────────────────────────────────────────┐
│  SIDEBAR     │  TOPBAR: judul halaman | badge "Data simulasi"      │
│  (240 px)    │         | tombol Login Admin                        │
│              ├────────────────────────────────────────────────────┤
│  Logo        │  FILTER BAR: [Tanggal ▾][Kategori ▾][Channel ▾]     │
│  EbonyCraft  │              [Wilayah ▾]            [Reset]         │
│  Palu        ├────────────────────────────────────────────────────┤
│              │  KPI ROW: [KPI 1][KPI 2][KPI 3][KPI 4]              │
│  • Ringkasan ├────────────────────────────────────────────────────┤
│  • Produk    │  GRID CHART (12 kolom)                              │
│  • Channel & │  ┌───────── 8 ─────────┐ ┌──────── 4 ───────┐      │
│    Wilayah   │  │  Chart              │ │  Chart           │      │
│  • Pelanggan │  └─────────────────────┘ └──────────────────┘      │
│  • Operasional├───────────────────────────────────────────────────┤
│  • Prediksi  │  INSIGHT OTOMATIS (kartu ber-ikon bohlam)           │
│              │                                                     │
│  Footer:     │                                                     │
│  v1.0        │                                                     │
└──────────────┴────────────────────────────────────────────────────┘
```

### 3.2 Breakpoint Responsif
| Lebar | Perilaku |
|-------|----------|
| ≥ 1200 px | Sidebar tetap, grid 12 kolom |
| 768–1199 px | Sidebar dapat dilipat (ikon saja), chart 6 kolom |
| < 768 px | Sidebar jadi menu *hamburger*, chart 1 kolom, filter jadi panel *drawer*, tinggi chart 260 px |

### 3.3 Komponen Utama
| Komponen | Spesifikasi |
|----------|-------------|
| **Kartu KPI** | Ikon, label, angka besar, delta vs periode sebelumnya (▲ hijau / ▼ merah) |
| **Kartu Chart** | Header (judul + subjudul + menu ⋮ [Unduh PNG, Ekspor CSV, Layar penuh]), area chart, footer sumber data |
| **Filter Bar** | Date range picker, 3 select; perubahan langsung memuat ulang chart (debounce 300 ms) |
| **Panel Insight** | 2–4 poin kalimat, ikon sesuai sentimen (naik, turun, info) |
| **Tabel** | Header `--ebony-700` teks putih, baris zebra krem, angka rata kanan |
| **Badge** | "Data simulasi" (amber muda), "Model terpilih" (hijau) |
| **State** | *Skeleton loader* saat memuat; *empty state* "Tidak ada data untuk filter ini"; *error state* dengan tombol "Coba lagi" |

## 4. Wireframe per Halaman

### 4.1 Ringkasan Penjualan (`/`)
KPI: Total Pendapatan · Jumlah Pesanan · AOV · Margin Kotor
```
[ C01 Tren Pendapatan Bulanan (8)         ][ C03 Pendapatan vs Laba Kotor (4) ]
[ C02 Perbandingan Tahunan per Bulan (6)  ][ C04 Heatmap Musiman (6)          ]
[ C05 Penjualan per Hari dalam Seminggu (6) ][ Insight Otomatis (6)           ]
```

### 4.2 Analisis Produk (`/produk`)
KPI: Produk Aktif · Produk Terlaris · Kontribusi Top 3 · Rata-rata Margin Produk
```
[ C06 Top 10 Produk (6)        ][ C07 Komposisi Kategori (6)       ]
[ C08 Pareto 80/20 (6)         ][ C09 Bubble Harga-Volume-Margin (6) ]
[ C10 Tren per Kategori (12)                                          ]
[ Insight (12)                                                        ]
```

### 4.3 Channel & Wilayah (`/channel-wilayah`)
KPI: Channel Terbesar · Porsi Online · Wilayah Terbesar · Porsi Luar Sulteng
```
[ C11 Pendapatan per Channel (6)  ][ C12 Pergeseran Porsi Channel (6) ]
[ C13 Treemap Wilayah (8)                     ][ C14 Segmen Pembeli (4) ]
[ Insight (12)                                                         ]
```

### 4.4 Pelanggan & Transaksi (`/pelanggan`)
KPI: Total Pelanggan · % Pelanggan Ulang · Pesanan/Bulan · AOV
```
[ C15 Baru vs Ulang (8)              ][ C17 Metode Pembayaran (4) ]
[ C16 Distribusi Nilai Transaksi (6) ][ C18 Tren AOV (6)          ]
[ Insight (12)                                                     ]
```

### 4.5 Operasional & Biaya (`/operasional`)
KPI: Total HPP · Rasio Bahan Baku · Rata-rata Lead Time · Perputaran Stok
```
[ C19 Stok vs Terjual (12)                                         ]
[ C20 Struktur Biaya per Tahun (6) ][ C21 Boxplot Lead Time (6)    ]
[ Insight (12)                                                     ]
```

### 4.6 Prediksi Penjualan (`/prediksi`)
KPI: Prediksi 12 Bulan (total) · Pertumbuhan vs 12 Bulan Terakhir · Bulan Puncak · MAPE Model Terpilih
```
[ C22 Prediksi 12 Bulan + Interval (12)                            ]
[ C23 Backtest Aktual vs 3 Model (8) ][ C24 Akurasi Model (4)      ]
[ C25 Prediksi per Kategori (12)                                   ]
[ Tabel Rekomendasi Stok & Produksi (12)                           ]
[ Panel Admin: [Jalankan Ulang Prediksi] (hanya jika login)        ]
```

## 5. Spesifikasi Visual Tiap Chart (ApexCharts)

| ID | Tipe ApexCharts | Tinggi | Warna / Catatan visual |
|----|-----------------|--------|------------------------|
| C01 | `area` (kurva halus, 2 px) | 340 | Amber + gradien 20%; titik hanya saat hover |
| C02 | `bar` grouped (kolom) | 320 | Satu warna per tahun (palet chart); legenda atas |
| C03 | `line` + `column` (mixed) | 320 | Kolom amber (pendapatan), garis hijau (margin %), sumbu Y ganda |
| C04 | `heatmap` | 320 | Skala krem → amber → mahogany; label nilai ringkas (juta) |
| C05 | `bar` (kolom) | 300 | Hari tertinggi disorot amber, lainnya pasir |
| C06 | `bar` horizontal | 340 | Urut menurun, label Rp ringkas di ujung batang |
| C07 | `donut` | 320 | Palet chart; total di tengah |
| C08 | `bar` + `line` (Pareto) | 320 | Kolom amber, garis kumulatif mahogany, garis acuan 80% putus-putus |
| C09 | `bubble` | 340 | Sumbu X = harga, Y = unit terjual, ukuran = margin; warna = kategori |
| C10 | `area` stacked | 340 | Palet chart; urut dari kategori terbesar |
| C11 | `bar` (kolom) | 320 | Urut menurun; amber |
| C12 | `bar` stacked 100% | 320 | Palet chart; label persen di dalam segmen |
| C13 | `treemap` | 360 | Warna per kelompok wilayah (Sulteng, Domestik, Luar negeri) |
| C14 | `pie` | 320 | Palet chart; label persen |
| C15 | `bar` stacked | 320 | Baru = amber, Ulang = mahogany |
| C16 | `bar` (histogram, jarak antar kolom 0) | 300 | Kelas Rp 50 rb; modus disorot |
| C17 | `radialBar` | 320 | Satu cincin per metode; palet chart |
| C18 | `line` | 300 | Amber; garis tren linear tipis putus-putus |
| C19 | `area` + `bar` (mixed) | 340 | Area pasir (stok), kolom amber (terjual) |
| C20 | `bar` stacked 100% horizontal | 320 | Palet chart per komponen biaya |
| C21 | `boxPlot` | 320 | Kotak mahogany/amber; tooltip min, Q1, median, Q3, maks |
| C22 | `line` + `rangeArea` | 380 | Aktual solid amber; prediksi putus-putus biru; interval biru 15%; garis vertikal pemisah "Hari ini" |
| C23 | `line` multi | 340 | Aktual hitam tebal; tiap model satu warna; area uji diberi anotasi |
| C24 | `bar` grouped | 300 | MAPE (amber) & NRMSE (mahogany); model terbaik diberi badge hijau |
| C25 | `bar` stacked | 340 | Palet chart per kategori; total di atas kolom |

**Aturan umum chart:** font Inter 12 px; grid horizontal tipis `#EFE6D6`; tooltip berisi nilai Rupiah penuh; animasi 400 ms (nonaktif jika `prefers-reduced-motion`); unduh PNG dan CSV tersedia di menu ⋮.

## 6. Insight Otomatis (Contoh Templat Kalimat)

| Halaman | Templat |
|---------|---------|
| Ringkasan | "Pendapatan {periode} mencapai {total}, {naik/turun} {x}% dibanding periode sebelumnya. Bulan tertinggi: {bulan}." |
| Produk | "{n} produk teratas menyumbang {x}% pendapatan. Produk bermargin tertinggi: {nama} ({y}%)." |
| Channel | "Porsi penjualan online (IG, WA, marketplace) {x}%, naik {y} poin dari tahun lalu." |
| Pelanggan | "Pelanggan ulang {x}% dari total transaksi; AOV rata-rata {aov}." |
| Operasional | "Bahan baku menyerap {x}% biaya. Produk {nama} memiliki lead time terpanjang ({y} hari)." |
| Prediksi | "Model {nama} (MAPE {x}%) memprediksi pendapatan 12 bulan ke depan {total}. Puncak diperkirakan {bulan}; siapkan stok mulai {bulan-2}." |

## 7. Aksesibilitas

- Semua kontrol dapat dioperasikan dengan keyboard; fokus terlihat (outline amber 2 px).
- `aria-label` pada chart dan ringkasan teks tersembunyi (*visually hidden*) berisi poin utama chart.
- Tidak mengandalkan warna saja: legenda, label langsung, dan pola/garis putus-putus untuk prediksi.
- Hormati `prefers-reduced-motion` dan `prefers-color-scheme` (mode gelap opsional).
- Ukuran target sentuh ≥ 44 px di ponsel.

## 8. Mode Gelap (Opsional / Could)

| Token | Nilai gelap |
|-------|-------------|
| `--cream` (latar) | `#14100D` |
| `--surface` | `#1E1814` |
| `--text` | `#F2E9DC` |
| `--sand` (border) | `#3A2F27` |
Warna chart tetap, grid diganti `#2B231D`.

## 9. Aset

| Aset | Keterangan |
|------|------------|
| Logo | Teks "EbonyCraft Palu" + ikon sederhana (serat kayu/siluet burung Maleo), format SVG |
| Ikon | Set ikon garis konsisten (mis. Lucide, disalin lokal sebagai SVG) |
| Favicon | Monogram "E" amber di atas bulat eboni |
| Gambar hero (opsional) | Foto produk bila ada; bila tidak, pola serat kayu via CSS gradient |

## 10. Checklist Kualitas Desain

- [ ] Palet, tipografi, dan spasi konsisten dengan token.
- [ ] Setiap chart memiliki judul + subjudul fungsi.
- [ ] Format `id-ID` benar di tooltip dan sumbu.
- [ ] Skeleton, empty, dan error state tersedia.
- [ ] Layout teruji di 360 px, 768 px, 1366 px, 1920 px.
- [ ] Kontras diperiksa (WCAG AA).
- [ ] Banner "Data simulasi" terlihat di semua halaman.
