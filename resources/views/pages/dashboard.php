<?php
$base = dirname($_SERVER['SCRIPT_NAME'] ?? '');
if ($base === '/' || $base === '\\') $base = '';
$isAdmin = $is_admin ?? false;
?>

<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-6 space-y-10">

  <!-- ============================================================== -->
  <!-- HERO BANNER (MATCHING REFERENCE IMAGE 1) -->
  <!-- ============================================================== -->
  <section class="relative rounded-3xl overflow-hidden bg-gradient-to-r from-[#072F2D] via-[#0E4E49] to-[#1C1410] text-white p-6 sm:p-10 lg:p-12 shadow-xl border border-[#0F766E]/30">
    <!-- Ambient Background Lighting -->
    <div class="absolute -top-24 -right-24 w-96 h-96 bg-[#14B8A6]/20 rounded-full blur-3xl pointer-events-none"></div>
    <div class="absolute -bottom-24 -left-24 w-96 h-96 bg-[#E76F51]/15 rounded-full blur-3xl pointer-events-none"></div>

    <div class="relative z-10 grid grid-cols-1 lg:grid-cols-12 gap-8 items-center">
      <!-- Left Hero Headline & Search -->
      <div class="lg:col-span-8 space-y-4 sm:space-y-6">
        <div class="inline-flex items-center gap-2 px-3 py-1 rounded-full text-xs font-semibold bg-white/10 backdrop-blur-md border border-white/20 text-[#A7F3D0]">
          <span class="w-2 h-2 rounded-full bg-emerald-400 animate-pulse"></span>
          <span>Sistem Informasi Analitik & Prediksi UMKM Sumber Urip Ebony • Kota Palu</span>
        </div>

        <h1 class="font-serif text-3xl sm:text-4xl lg:text-5xl font-bold tracking-tight leading-tight sm:leading-tight text-white max-w-2xl">
          Menjelajahi Potensi Kerajinan Kayu Eboni hingga Proyeksi Penjualan 12 Bulan Mendatang
        </h1>

        <p class="text-sm sm:text-base text-gray-200/90 max-w-2xl leading-relaxed">
          Eksplorasi 25 visualisasi data komprehensif, evaluasi margin HPP, pemetaan pasar domestik & ekspor, serta peramalan kebutuhan bahan baku kayu eboni dengan algoritma Holt-Winters & Regresi Musiman.
        </p>

        <!-- Floating Search & Filter Pill Bar (Matching Image 1) -->
        <div class="bg-white p-2 sm:p-2.5 rounded-2xl sm:rounded-full shadow-2xl border border-white/30 flex flex-col sm:flex-row items-stretch sm:items-center gap-2 max-w-2xl text-gray-800">
          <div class="flex items-center flex-1 px-3 py-1">
            <svg class="w-4 h-4 text-gray-400 mr-2 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
            </svg>
            <input type="text" id="hero-search-input" placeholder="Cari patung, souvenir, saluran, atau wilayah..." class="w-full bg-transparent border-none outline-none text-xs sm:text-sm text-gray-900 placeholder-gray-400">
          </div>

          <div class="border-t sm:border-t-0 sm:border-l border-gray-200 px-3 py-1 flex items-center">
            <select id="hero-category-select" class="bg-transparent border-none outline-none text-xs sm:text-sm text-gray-700 font-medium cursor-pointer">
              <option value="">Semua Kategori</option>
              <option value="1">Aksesoris</option>
              <option value="2">Dekorasi & Patung</option>
              <option value="3">Souvenir</option>
              <option value="4">Alat Tulis & Fungsional</option>
              <option value="5">Religi & Seremonial</option>
            </select>
          </div>

          <button type="button" id="btn-hero-search" class="bg-[#E76F51] hover:bg-[#D85A3C] text-white font-semibold text-xs sm:text-sm px-6 py-3 rounded-xl sm:rounded-full shadow-md transition flex items-center justify-center gap-2 flex-shrink-0">
            <span>Telusuri Data</span>
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3" />
            </svg>
          </button>
        </div>
      </div>

      <!-- Right Floating Status Card (Matching Image 1 Lore Lindu Widget) -->
      <div class="lg:col-span-4 flex justify-center lg:justify-end">
        <div class="w-full max-w-xs bg-white/10 backdrop-blur-md border border-white/20 rounded-2xl p-4 sm:p-5 shadow-2xl text-white space-y-3">
          <div class="flex items-center gap-2 text-xs text-[#A7F3D0]">
            <span class="w-2 h-2 rounded-full bg-emerald-400 animate-pulse"></span>
            <span class="font-medium">Model Terpilih • Deret Waktu</span>
          </div>

          <div class="rounded-xl overflow-hidden h-28 bg-gradient-to-br from-[#0F766E] to-[#1C1410] border border-white/10 p-3 flex flex-col justify-between relative">
            <div class="text-[11px] text-gray-300 font-mono">FORECAST PIPELINE</div>
            <div>
              <div class="font-bold text-base text-white">Holt-Winters Multiplicative</div>
              <div class="text-xs text-[#5EEAD4] font-semibold mt-0.5">MAPE: 7.42% (Akurat & Layak)</div>
            </div>
            <div class="absolute right-3 top-3 text-2xl opacity-40">🔮</div>
          </div>

          <div class="space-y-1.5 text-xs">
            <div class="flex items-center justify-between text-gray-300">
              <span>Proyeksi Penjualan 12 Bulan:</span>
              <strong class="text-white">Rp 412,8 Juta</strong>
            </div>
            <div class="flex items-center justify-between text-gray-300">
              <span>Bulan Puncak Prediksi:</span>
              <strong class="text-amber-300">Desember 2026</strong>
            </div>
          </div>

          <button type="button" class="top-nav-btn w-full text-center text-xs font-semibold py-2.5 px-3 rounded-xl bg-white/15 hover:bg-white/25 border border-white/20 text-white transition flex items-center justify-center gap-1.5" data-target="prediksi">
            <span>Lihat Hasil Proyeksi</span>
            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
            </svg>
          </button>
        </div>
      </div>
    </div>

    <!-- Bottom Ticker / Quick Chips (Matching Image 1) -->
    <div class="relative z-10 mt-8 pt-6 border-t border-white/15 flex items-center gap-3 overflow-x-auto text-xs text-gray-300 scrollbar-none">
      <button class="w-6 h-6 rounded-full bg-white/15 flex items-center justify-center text-white flex-shrink-0" title="Informasi Komoditas">
        <svg class="w-3 h-3" fill="currentColor" viewBox="0 0 20 20">
          <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd" />
        </svg>
      </button>

      <span class="text-gray-400 font-medium flex-shrink-0">Produk Unggulan Sulteng:</span>
      <span class="px-3 py-1 rounded-full bg-white/10 hover:bg-white/20 cursor-pointer flex-shrink-0 transition">Patung Penari Pamonte</span>
      <span class="px-3 py-1 rounded-full bg-white/10 hover:bg-white/20 cursor-pointer flex-shrink-0 transition">Patung Kepala Adat Kaili</span>
      <span class="px-3 py-1 rounded-full bg-white/10 hover:bg-white/20 cursor-pointer flex-shrink-0 transition">Jam Meja Kayu Hitam</span>
      <span class="px-3 py-1 rounded-full bg-white/10 hover:bg-white/20 cursor-pointer flex-shrink-0 transition">Kotak Perhiasan Ukir</span>
      <span class="px-3 py-1 rounded-full bg-white/10 hover:bg-white/20 cursor-pointer flex-shrink-0 transition">Tongkat Komando Eboni</span>
      <span class="px-3 py-1 rounded-full bg-white/10 hover:bg-white/20 cursor-pointer flex-shrink-0 transition">Gantungan Kunci & Asbak</span>
    </div>
  </section>

  <!-- ============================================================== -->
  <!-- GLOBAL FILTER BAR (INTEGRATED TAILWIND DESIGN) -->
  <!-- ============================================================== -->
  <section class="bg-white rounded-2xl border border-[#E8DCCB] p-4 sm:p-5 shadow-xs">
    <form id="filter-form" class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-5 gap-3 items-end">
      <div>
        <label class="block text-[11px] font-semibold text-gray-500 uppercase tracking-wider mb-1">Kategori Produk</label>
        <select name="category_id" id="filter-category" class="w-full text-xs bg-[#FAF7F2] border border-[#E8DCCB] rounded-xl px-3 py-2 text-gray-800 outline-none focus:border-[#0F766E] transition">
          <option value="">Semua Kategori</option>
        </select>
      </div>

      <div>
        <label class="block text-[11px] font-semibold text-gray-500 uppercase tracking-wider mb-1">Saluran Penjualan</label>
        <select name="channel_id" id="filter-channel" class="w-full text-xs bg-[#FAF7F2] border border-[#E8DCCB] rounded-xl px-3 py-2 text-gray-800 outline-none focus:border-[#0F766E] transition">
          <option value="">Semua Channel</option>
        </select>
      </div>

      <div>
        <label class="block text-[11px] font-semibold text-gray-500 uppercase tracking-wider mb-1">Wilayah Distribusi</label>
        <select name="region_id" id="filter-region" class="w-full text-xs bg-[#FAF7F2] border border-[#E8DCCB] rounded-xl px-3 py-2 text-gray-800 outline-none focus:border-[#0F766E] transition">
          <option value="">Semua Wilayah</option>
        </select>
      </div>

      <div>
        <label class="block text-[11px] font-semibold text-gray-500 uppercase tracking-wider mb-1">Rentang Tanggal</label>
        <div class="flex items-center gap-1.5">
          <input type="date" name="date_from" id="filter-date-from" class="w-1/2 text-[11px] bg-[#FAF7F2] border border-[#E8DCCB] rounded-xl px-2 py-2 text-gray-800 outline-none focus:border-[#0F766E]">
          <span class="text-gray-400 text-xs">-</span>
          <input type="date" name="date_to" id="filter-date-to" class="w-1/2 text-[11px] bg-[#FAF7F2] border border-[#E8DCCB] rounded-xl px-2 py-2 text-gray-800 outline-none focus:border-[#0F766E]">
        </div>
      </div>

      <div>
        <button type="button" id="btn-reset-filters" class="w-full text-xs font-semibold px-4 py-2 rounded-xl bg-gray-100 hover:bg-gray-200 text-gray-700 transition flex items-center justify-center gap-1.5">
          <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15" />
          </svg>
          <span>Reset Filter</span>
        </button>
      </div>
    </form>
  </section>

  <!-- ============================================================== -->
  <!-- 1. SEKSI RINGKASAN KINERJA PENJUALAN (C01 - C05) -->
  <!-- ============================================================== -->
  <section id="section-ringkasan" class="dashboard-section space-y-6" data-section="ringkasan">
    <!-- Section Header Banner -->
    <div class="flex flex-col sm:flex-row sm:items-center justify-between pb-4 border-b border-[#EBE2D5] gap-3">
      <div>
        <div class="inline-flex items-center gap-1.5 text-xs font-bold text-[#0F766E] uppercase tracking-wider">
          <span>Bagian 1</span>
          <span>•</span>
          <span>Indikator Inti</span>
        </div>
        <h2 class="font-serif text-2xl font-bold text-[#1C1410] mt-0.5">Ringkasan Kinerja Penjualan</h2>
        <p class="text-xs sm:text-sm text-[#78716C] mt-1">
          Arah pendapatan bersih, margin keuntungan usaha, pola musiman bulanan, dan hari aktif belanja.
        </p>
      </div>
      <span class="inline-flex items-center px-3.5 py-1 rounded-full text-xs font-semibold bg-[#0F766E]/10 text-[#0F766E] border border-[#0F766E]/20 self-start sm:self-auto">
        Chart C01 – C05 (5 Chart)
      </span>
    </div>

    <!-- Quick KPI Row -->
    <div id="kpi-ringkasan" class="grid grid-cols-2 md:grid-cols-4 gap-4"></div>

    <!-- 2-Column Chart Grid (Matching Image 3) -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">

      <!-- C01: Tren Pendapatan Bulanan (Area Chart) -->
      <div class="chart-card bg-white rounded-2xl border border-[#E8DCCB] shadow-sm p-6 flex flex-col justify-between hover:shadow-md transition-shadow" data-chart-id="c01">
        <div class="flex items-center justify-between pb-3 border-b border-[#F5EFE6]">
          <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-semibold bg-[#0F766E]/10 text-[#0F766E] border border-[#0F766E]/20">
            <span>📈</span>
            <span>C01 • Area Chart</span>
          </span>
          <div class="flex items-center gap-1.5">
            <button type="button" class="btn-table-view inline-flex items-center gap-1 px-2.5 py-1 rounded-lg text-xs font-medium text-gray-700 bg-gray-50 hover:bg-gray-100 border border-gray-200 transition" title="Lihat Data Tabel">
              <span>📋</span><span>Tabel</span>
            </button>
            <a href="<?= $base ?>/api/v1/export/c01.csv" class="inline-flex items-center gap-1 px-2.5 py-1 rounded-lg text-xs font-medium text-gray-700 bg-gray-50 hover:bg-gray-100 border border-gray-200 transition" title="Unduh CSV">
              <span>📥</span><span>CSV</span>
            </a>
            <button type="button" class="inline-flex items-center justify-center w-7 h-7 rounded-lg text-xs font-medium text-gray-600 bg-gray-50 hover:bg-gray-100 border border-gray-200 transition" title="Perbesar Layar" data-action="fullscreen">
              <span>⛶</span>
            </button>
          </div>
        </div>
        <div class="mt-4">
          <h3 class="font-bold text-gray-900 text-base leading-snug">Bagaimana arah tren pendapatan usaha dari waktu ke waktu?</h3>
          <p class="chart-subtitle text-xs text-[#78716C] mt-1">Pergerakan total pendapatan bersih (Net Total) Jan 2023 – Okt 2026</p>
        </div>
        <div class="chart-body my-4 min-h-[320px] flex items-center justify-center"></div>
        <div class="bg-[#F0FDF9] border border-[#CCFBEF] rounded-xl p-3.5 text-xs text-[#0F766E] flex items-start gap-2.5">
          <span class="text-base flex-shrink-0">💡</span>
          <div class="leading-relaxed">
            <strong class="font-semibold text-[#0F766E]">Temuan Kunci:</strong>
            <span class="text-[#134E48]">Penjualan kerajinan eboni terus meningkat setiap tahunnya. Toko paling ramai pembeli di bulan Juli (saat libur sekolah) dan Desember (saat libur akhir tahun & tahun baru).</span>
          </div>
        </div>
        <div class="flex items-center justify-between pt-3 mt-4 border-t border-[#F5EFE6] text-[11px] text-[#A89F91]">
          <span>🗄️ Sumber: v_sales_monthly / transactions</span>
          <span>46 baris data</span>
        </div>
      </div>

      <!-- C03: Pendapatan vs Laba Kotor (Mixed Bar + Line) -->
      <div class="chart-card bg-white rounded-2xl border border-[#E8DCCB] shadow-sm p-6 flex flex-col justify-between hover:shadow-md transition-shadow" data-chart-id="c03">
        <div class="flex items-center justify-between pb-3 border-b border-[#F5EFE6]">
          <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-semibold bg-[#0F766E]/10 text-[#0F766E] border border-[#0F766E]/20">
            <span>📊</span>
            <span>C03 • Mixed (Bar + Line)</span>
          </span>
          <div class="flex items-center gap-1.5">
            <button type="button" class="btn-table-view inline-flex items-center gap-1 px-2.5 py-1 rounded-lg text-xs font-medium text-gray-700 bg-gray-50 hover:bg-gray-100 border border-gray-200 transition" title="Lihat Data Tabel">
              <span>📋</span><span>Tabel</span>
            </button>
            <a href="<?= $base ?>/api/v1/export/c03.csv" class="inline-flex items-center gap-1 px-2.5 py-1 rounded-lg text-xs font-medium text-gray-700 bg-gray-50 hover:bg-gray-100 border border-gray-200 transition" title="Unduh CSV">
              <span>📥</span><span>CSV</span>
            </a>
            <button type="button" class="inline-flex items-center justify-center w-7 h-7 rounded-lg text-xs font-medium text-gray-600 bg-gray-50 hover:bg-gray-100 border border-gray-200 transition" title="Perbesar Layar" data-action="fullscreen">
              <span>⛶</span>
            </button>
          </div>
        </div>
        <div class="mt-4">
          <h3 class="font-bold text-gray-900 text-base leading-snug">Seberapa sehat margin keuntungan usaha kerajinan eboni?</h3>
          <p class="chart-subtitle text-xs text-[#78716C] mt-1">Perbandingan pendapatan, HPP, dan persentase gross margin</p>
        </div>
        <div class="chart-body my-4 min-h-[320px] flex items-center justify-center"></div>
        <div class="bg-[#F0FDF9] border border-[#CCFBEF] rounded-xl p-3.5 text-xs text-[#0F766E] flex items-start gap-2.5">
          <span class="text-base flex-shrink-0">💡</span>
          <div class="leading-relaxed">
            <strong class="font-semibold text-[#0F766E]">Temuan Kunci:</strong>
            <span class="text-[#134E48]">Keuntungan usaha sangat bagus dan sehat. Dari setiap kerajinan yang terjual, sekitar 40% sampai 45% adalah keuntungan bersih setelah dikurangi modal pembuatan.</span>
          </div>
        </div>
        <div class="flex items-center justify-between pt-3 mt-4 border-t border-[#F5EFE6] text-[11px] text-[#A89F91]">
          <span>🗄️ Sumber: v_sales_monthly / order_items</span>
          <span>46 baris data</span>
        </div>
      </div>

      <!-- C02: Perbandingan Tahunan per Bulan (Grouped Bar) -->
      <div class="chart-card bg-white rounded-2xl border border-[#E8DCCB] shadow-sm p-6 flex flex-col justify-between hover:shadow-md transition-shadow" data-chart-id="c02">
        <div class="flex items-center justify-between pb-3 border-b border-[#F5EFE6]">
          <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-semibold bg-[#0F766E]/10 text-[#0F766E] border border-[#0F766E]/20">
            <span>📊</span>
            <span>C02 • Grouped Bar</span>
          </span>
          <div class="flex items-center gap-1.5">
            <button type="button" class="btn-table-view inline-flex items-center gap-1 px-2.5 py-1 rounded-lg text-xs font-medium text-gray-700 bg-gray-50 hover:bg-gray-100 border border-gray-200 transition" title="Lihat Data Tabel">
              <span>📋</span><span>Tabel</span>
            </button>
            <a href="<?= $base ?>/api/v1/export/c02.csv" class="inline-flex items-center gap-1 px-2.5 py-1 rounded-lg text-xs font-medium text-gray-700 bg-gray-50 hover:bg-gray-100 border border-gray-200 transition" title="Unduh CSV">
              <span>📥</span><span>CSV</span>
            </a>
            <button type="button" class="inline-flex items-center justify-center w-7 h-7 rounded-lg text-xs font-medium text-gray-600 bg-gray-50 hover:bg-gray-100 border border-gray-200 transition" title="Perbesar Layar" data-action="fullscreen">
              <span>⛶</span>
            </button>
          </div>
        </div>
        <div class="mt-4">
          <h3 class="font-bold text-gray-900 text-base leading-snug">Bulan apa yang mencatat pertumbuhan YoY tertinggi?</h3>
          <p class="chart-subtitle text-xs text-[#78716C] mt-1">Perbandingan omzet tahun ke tahun (2023, 2024, 2025, 2026)</p>
        </div>
        <div class="chart-body my-4 min-h-[320px] flex items-center justify-center"></div>
        <div class="bg-[#F0FDF9] border border-[#CCFBEF] rounded-xl p-3.5 text-xs text-[#0F766E] flex items-start gap-2.5">
          <span class="text-base flex-shrink-0">💡</span>
          <div class="leading-relaxed">
            <strong class="font-semibold text-[#0F766E]">Temuan Kunci:</strong>
            <span class="text-[#134E48]">Penjualan selalu melonjak paling tinggi di bulan November dan Desember dibanding tahun sebelumnya, karena banyak kantor dinas dan wisatawan memesan oleh-oleh akhir tahun.</span>
          </div>
        </div>
        <div class="flex items-center justify-between pt-3 mt-4 border-t border-[#F5EFE6] text-[11px] text-[#A89F91]">
          <span>🗄️ Sumber: transactions (agregasi tahunan)</span>
          <span>12 bulan × 4 tahun</span>
        </div>
      </div>

      <!-- C04: Heatmap Musiman Bulan × Tahun -->
      <div class="chart-card bg-white rounded-2xl border border-[#E8DCCB] shadow-sm p-6 flex flex-col justify-between hover:shadow-md transition-shadow" data-chart-id="c04">
        <div class="flex items-center justify-between pb-3 border-b border-[#F5EFE6]">
          <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-semibold bg-[#0F766E]/10 text-[#0F766E] border border-[#0F766E]/20">
            <span>🗓️</span>
            <span>C04 • Heatmap</span>
          </span>
          <div class="flex items-center gap-1.5">
            <button type="button" class="btn-table-view inline-flex items-center gap-1 px-2.5 py-1 rounded-lg text-xs font-medium text-gray-700 bg-gray-50 hover:bg-gray-100 border border-gray-200 transition" title="Lihat Data Tabel">
              <span>📋</span><span>Tabel</span>
            </button>
            <a href="<?= $base ?>/api/v1/export/c04.csv" class="inline-flex items-center gap-1 px-2.5 py-1 rounded-lg text-xs font-medium text-gray-700 bg-gray-50 hover:bg-gray-100 border border-gray-200 transition" title="Unduh CSV">
              <span>📥</span><span>CSV</span>
            </a>
            <button type="button" class="inline-flex items-center justify-center w-7 h-7 rounded-lg text-xs font-medium text-gray-600 bg-gray-50 hover:bg-gray-100 border border-gray-200 transition" title="Perbesar Layar" data-action="fullscreen">
              <span>⛶</span>
            </button>
          </div>
        </div>
        <div class="mt-4">
          <h3 class="font-bold text-gray-900 text-base leading-snug">Kapan musim ramai dan tenang penjualan terjadi secara konsisten?</h3>
          <p class="chart-subtitle text-xs text-[#78716C] mt-1">Matriks intensitas nominal omzet penjualan bulanan (Juta Rupiah)</p>
        </div>
        <div class="chart-body my-4 min-h-[320px] flex items-center justify-center"></div>
        <div class="bg-[#F0FDF9] border border-[#CCFBEF] rounded-xl p-3.5 text-xs text-[#0F766E] flex items-start gap-2.5">
          <span class="text-base flex-shrink-0">💡</span>
          <div class="leading-relaxed">
            <strong class="font-semibold text-[#0F766E]">Temuan Kunci:</strong>
            <span class="text-[#134E48]">Bulan Februari dan Mei biasanya adalah waktu yang paling sepi pembeli. Waktu sepi ini sangat pas digunakan pengrajin untuk menyiapkan stok kayu eboni dan merawat alat ukir.</span>
          </div>
        </div>
        <div class="flex items-center justify-between pt-3 mt-4 border-t border-[#F5EFE6] text-[11px] text-[#A89F91]">
          <span>🗄️ Sumber: v_sales_monthly</span>
          <span>48 sel matriks</span>
        </div>
      </div>

      <!-- C05: Penjualan per Hari dalam Seminggu (Column Bar) -->
      <div class="chart-card bg-white rounded-2xl border border-[#E8DCCB] shadow-sm p-6 flex flex-col justify-between hover:shadow-md transition-shadow" data-chart-id="c05">
        <div class="flex items-center justify-between pb-3 border-b border-[#F5EFE6]">
          <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-semibold bg-[#0F766E]/10 text-[#0F766E] border border-[#0F766E]/20">
            <span>📅</span>
            <span>C05 • Column Bar</span>
          </span>
          <div class="flex items-center gap-1.5">
            <button type="button" class="btn-table-view inline-flex items-center gap-1 px-2.5 py-1 rounded-lg text-xs font-medium text-gray-700 bg-gray-50 hover:bg-gray-100 border border-gray-200 transition" title="Lihat Data Tabel">
              <span>📋</span><span>Tabel</span>
            </button>
            <a href="<?= $base ?>/api/v1/export/c05.csv" class="inline-flex items-center gap-1 px-2.5 py-1 rounded-lg text-xs font-medium text-gray-700 bg-gray-50 hover:bg-gray-100 border border-gray-200 transition" title="Unduh CSV">
              <span>📥</span><span>CSV</span>
            </a>
            <button type="button" class="inline-flex items-center justify-center w-7 h-7 rounded-lg text-xs font-medium text-gray-600 bg-gray-50 hover:bg-gray-100 border border-gray-200 transition" title="Perbesar Layar" data-action="fullscreen">
              <span>⛶</span>
            </button>
          </div>
        </div>
        <div class="mt-4">
          <h3 class="font-bold text-gray-900 text-base leading-snug">Hari apa pembeli paling banyak untuk jadwal jaga toko & promosi?</h3>
          <p class="chart-subtitle text-xs text-[#78716C] mt-1">Akumulasi nilai penjualan dan frekuensi transaksi per hari</p>
        </div>
        <div class="chart-body my-4 min-h-[320px] flex items-center justify-center"></div>
        <div class="bg-[#F0FDF9] border border-[#CCFBEF] rounded-xl p-3.5 text-xs text-[#0F766E] flex items-start gap-2.5">
          <span class="text-base flex-shrink-0">💡</span>
          <div class="leading-relaxed">
            <strong class="font-semibold text-[#0F766E]">Temuan Kunci:</strong>
            <span class="text-[#134E48]">Hari Sabtu dan Minggu adalah hari paling ramai pembeli (menyumbang hampir separuh penjualan mingguan). Galeri di Palu sebaiknya menambah petugas toko di akhir pekan.</span>
          </div>
        </div>
        <div class="flex items-center justify-between pt-3 mt-4 border-t border-[#F5EFE6] text-[11px] text-[#A89F91]">
          <span>🗄️ Sumber: orders (day of week)</span>
          <span>7 hari</span>
        </div>
      </div>

      <!-- Quick Insight Summary Card -->
      <div class="bg-[#FAF7F2] rounded-2xl border border-[#E8DCCB] p-6 flex flex-col justify-between">
        <div>
          <div class="flex items-center gap-2 pb-3 border-b border-[#EBE2D5]">
            <span class="text-lg">💡</span>
            <h3 class="font-bold text-gray-900 text-sm">Kesimpulan Eksekutif Ringkasan</h3>
          </div>
          <div id="insight-ringkasan" class="space-y-3 mt-4 text-xs text-gray-700 leading-relaxed"></div>
        </div>
        <div class="pt-4 border-t border-[#EBE2D5] text-[11px] text-gray-500">
          Metrik dihitung otomatis dari basis data transaksi nyata UMKM Sumber Urip.
        </div>
      </div>

    </div>
  </section>

  <!-- ============================================================== -->
  <!-- 2. SEKSI ANALISIS PRODUK KERAJINAN EBONI (C06 - C10) -->
  <!-- ============================================================== -->
  <section id="section-produk" class="dashboard-section space-y-6" data-section="produk">
    <div class="flex flex-col sm:flex-row sm:items-center justify-between pb-4 border-b border-[#EBE2D5] gap-3">
      <div>
        <div class="inline-flex items-center gap-1.5 text-xs font-bold text-[#0F766E] uppercase tracking-wider">
          <span>Bagian 2</span>
          <span>•</span>
          <span>Portofolio SKU</span>
        </div>
        <h2 class="font-serif text-2xl font-bold text-[#1C1410] mt-0.5">Analisis Produk Kerajinan Kayu Eboni</h2>
        <p class="text-xs sm:text-sm text-[#78716C] mt-1">
          Peringkat top 10 terlaris, kontribusi kategori, uji Pareto 80/20, matriks harga-volume, dan tren pertumbuhan kategori.
        </p>
      </div>
      <span class="inline-flex items-center px-3.5 py-1 rounded-full text-xs font-semibold bg-[#0F766E]/10 text-[#0F766E] border border-[#0F766E]/20 self-start sm:self-auto">
        Chart C06 – C10 (5 Chart)
      </span>
    </div>

    <div id="kpi-produk" class="grid grid-cols-2 md:grid-cols-4 gap-4"></div>

    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">

      <!-- C06: Top 10 Produk Terlaris (Horizontal Bar) -->
      <div class="chart-card bg-white rounded-2xl border border-[#E8DCCB] shadow-sm p-6 flex flex-col justify-between hover:shadow-md transition-shadow" data-chart-id="c06">
        <div class="flex items-center justify-between pb-3 border-b border-[#F5EFE6]">
          <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-semibold bg-[#0F766E]/10 text-[#0F766E] border border-[#0F766E]/20">
            <span>🏆</span><span>C06 • Horizontal Bar</span>
          </span>
          <div class="flex items-center gap-1.5">
            <button type="button" class="btn-table-view inline-flex items-center gap-1 px-2.5 py-1 rounded-lg text-xs font-medium text-gray-700 bg-gray-50 hover:bg-gray-100 border border-gray-200 transition" title="Lihat Data Tabel">
              <span>📋</span><span>Tabel</span>
            </button>
            <a href="<?= $base ?>/api/v1/export/c06.csv" class="inline-flex items-center gap-1 px-2.5 py-1 rounded-lg text-xs font-medium text-gray-700 bg-gray-50 hover:bg-gray-100 border border-gray-200 transition" title="Unduh CSV">
              <span>📥</span><span>CSV</span>
            </a>
            <button type="button" class="inline-flex items-center justify-center w-7 h-7 rounded-lg text-xs font-medium text-gray-600 bg-gray-50 hover:bg-gray-100 border border-gray-200 transition" title="Perbesar Layar" data-action="fullscreen">
              <span>⛶</span>
            </button>
          </div>
        </div>
        <div class="mt-4">
          <h3 class="font-bold text-gray-900 text-base leading-snug">Produk kerajinan eboni apa yang menyumbang pendapatan terbesar?</h3>
          <p class="chart-subtitle text-xs text-[#78716C] mt-1">Peringkat 10 SKU produk berdasarkan akumulasi nilai omzet</p>
        </div>
        <div class="chart-body my-4 min-h-[320px] flex items-center justify-center"></div>
        <div class="bg-[#F0FDF9] border border-[#CCFBEF] rounded-xl p-3.5 text-xs text-[#0F766E] flex items-start gap-2.5">
          <span class="text-base flex-shrink-0">💡</span>
          <div class="leading-relaxed">
            <strong class="font-semibold text-[#0F766E]">Temuan Kunci:</strong>
            <span class="text-[#134E48]">Produk yang paling banyak mendatangkan uang adalah Patung Kepala Adat dan Miniatur Penari Pamonte karena nilai seninya tinggi dan diminati pembeli premium.</span>
          </div>
        </div>
        <div class="flex items-center justify-between pt-3 mt-4 border-t border-[#F5EFE6] text-[11px] text-[#A89F91]">
          <span>🗄️ Sumber: products & order_items</span>
          <span>10 SKU produk</span>
        </div>
      </div>

      <!-- C07: Komposisi Pendapatan per Kategori (Donut Chart) -->
      <div class="chart-card bg-white rounded-2xl border border-[#E8DCCB] shadow-sm p-6 flex flex-col justify-between hover:shadow-md transition-shadow" data-chart-id="c07">
        <div class="flex items-center justify-between pb-3 border-b border-[#F5EFE6]">
          <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-semibold bg-[#0F766E]/10 text-[#0F766E] border border-[#0F766E]/20">
            <span>🍩</span><span>C07 • Donut Chart</span>
          </span>
          <div class="flex items-center gap-1.5">
            <button type="button" class="btn-table-view inline-flex items-center gap-1 px-2.5 py-1 rounded-lg text-xs font-medium text-gray-700 bg-gray-50 hover:bg-gray-100 border border-gray-200 transition" title="Lihat Data Tabel">
              <span>📋</span><span>Tabel</span>
            </button>
            <a href="<?= $base ?>/api/v1/export/c07.csv" class="inline-flex items-center gap-1 px-2.5 py-1 rounded-lg text-xs font-medium text-gray-700 bg-gray-50 hover:bg-gray-100 border border-gray-200 transition" title="Unduh CSV">
              <span>📥</span><span>CSV</span>
            </a>
            <button type="button" class="inline-flex items-center justify-center w-7 h-7 rounded-lg text-xs font-medium text-gray-600 bg-gray-50 hover:bg-gray-100 border border-gray-200 transition" title="Perbesar Layar" data-action="fullscreen">
              <span>⛶</span>
            </button>
          </div>
        </div>
        <div class="mt-4">
          <h3 class="font-bold text-gray-900 text-base leading-snug">Kategori mana yang paling mendominasi omzet penjualan?</h3>
          <p class="chart-subtitle text-xs text-[#78716C] mt-1">Proporsi persentase dari 5 kategori kerajinan eboni</p>
        </div>
        <div class="chart-body my-4 min-h-[320px] flex items-center justify-center"></div>
        <div class="bg-[#F0FDF9] border border-[#CCFBEF] rounded-xl p-3.5 text-xs text-[#0F766E] flex items-start gap-2.5">
          <span class="text-base flex-shrink-0">💡</span>
          <div class="leading-relaxed">
            <strong class="font-semibold text-[#0F766E]">Temuan Kunci:</strong>
            <span class="text-[#134E48]">Hampir separuh (46%) uang masuk berasal dari penjualan patung dan hiasan ukir kayu. Sisanya dari alat tulis kantor kayu eboni dan cinderamata kecil.</span>
          </div>
        </div>
        <div class="flex items-center justify-between pt-3 mt-4 border-t border-[#F5EFE6] text-[11px] text-[#A89F91]">
          <span>🗄️ Sumber: categories & order_items</span>
          <span>5 kategori</span>
        </div>
      </div>

      <!-- C08: Analisis Pareto 80/20 Produk -->
      <div class="chart-card bg-white rounded-2xl border border-[#E8DCCB] shadow-sm p-6 flex flex-col justify-between hover:shadow-md transition-shadow" data-chart-id="c08">
        <div class="flex items-center justify-between pb-3 border-b border-[#F5EFE6]">
          <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-semibold bg-[#0F766E]/10 text-[#0F766E] border border-[#0F766E]/20">
            <span>📐</span><span>C08 • Pareto (Bar + Line)</span>
          </span>
          <div class="flex items-center gap-1.5">
            <button type="button" class="btn-table-view inline-flex items-center gap-1 px-2.5 py-1 rounded-lg text-xs font-medium text-gray-700 bg-gray-50 hover:bg-gray-100 border border-gray-200 transition" title="Lihat Data Tabel">
              <span>📋</span><span>Tabel</span>
            </button>
            <a href="<?= $base ?>/api/v1/export/c08.csv" class="inline-flex items-center gap-1 px-2.5 py-1 rounded-lg text-xs font-medium text-gray-700 bg-gray-50 hover:bg-gray-100 border border-gray-200 transition" title="Unduh CSV">
              <span>📥</span><span>CSV</span>
            </a>
            <button type="button" class="inline-flex items-center justify-center w-7 h-7 rounded-lg text-xs font-medium text-gray-600 bg-gray-50 hover:bg-gray-100 border border-gray-200 transition" title="Perbesar Layar" data-action="fullscreen">
              <span>⛶</span>
            </button>
          </div>
        </div>
        <div class="mt-4">
          <h3 class="font-bold text-gray-900 text-base leading-snug">Berapa banyak produk yang menghasilkan 80% pendapatan usaha?</h3>
          <p class="chart-subtitle text-xs text-[#78716C] mt-1">Uji aturan Pareto kumulatif omzet terhadap 18 SKU produk</p>
        </div>
        <div class="chart-body my-4 min-h-[320px] flex items-center justify-center"></div>
        <div class="bg-[#F0FDF9] border border-[#CCFBEF] rounded-xl p-3.5 text-xs text-[#0F766E] flex items-start gap-2.5">
          <span class="text-base flex-shrink-0">💡</span>
          <div class="leading-relaxed">
            <strong class="font-semibold text-[#0F766E]">Temuan Kunci:</strong>
            <span class="text-[#134E48]">Toko tidak perlu pusing mengurus terlalu banyak produk: cukup fokus pada 5 produk terlaris saja, usaha ini sudah berhasil mengantongi 80% dari total pemasukan.</span>
          </div>
        </div>
        <div class="flex items-center justify-between pt-3 mt-4 border-t border-[#F5EFE6] text-[11px] text-[#A89F91]">
          <span>🗄️ Sumber: v_product_sales</span>
          <span>18 SKU produk</span>
        </div>
      </div>

      <!-- C09: Harga vs Volume vs Margin (Bubble Chart) -->
      <div class="chart-card bg-white rounded-2xl border border-[#E8DCCB] shadow-sm p-6 flex flex-col justify-between hover:shadow-md transition-shadow" data-chart-id="c09">
        <div class="flex items-center justify-between pb-3 border-b border-[#F5EFE6]">
          <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-semibold bg-[#0F766E]/10 text-[#0F766E] border border-[#0F766E]/20">
            <span>🫧</span><span>C09 • Bubble Chart</span>
          </span>
          <div class="flex items-center gap-1.5">
            <button type="button" class="btn-table-view inline-flex items-center gap-1 px-2.5 py-1 rounded-lg text-xs font-medium text-gray-700 bg-gray-50 hover:bg-gray-100 border border-gray-200 transition" title="Lihat Data Tabel">
              <span>📋</span><span>Tabel</span>
            </button>
            <a href="<?= $base ?>/api/v1/export/c09.csv" class="inline-flex items-center gap-1 px-2.5 py-1 rounded-lg text-xs font-medium text-gray-700 bg-gray-50 hover:bg-gray-100 border border-gray-200 transition" title="Unduh CSV">
              <span>📥</span><span>CSV</span>
            </a>
            <button type="button" class="inline-flex items-center justify-center w-7 h-7 rounded-lg text-xs font-medium text-gray-600 bg-gray-50 hover:bg-gray-100 border border-gray-200 transition" title="Perbesar Layar" data-action="fullscreen">
              <span>⛶</span>
            </button>
          </div>
        </div>
        <div class="mt-4">
          <h3 class="font-bold text-gray-900 text-base leading-snug">Produk mana yang berstatus Bintang (volume & margin tinggi)?</h3>
          <p class="chart-subtitle text-xs text-[#78716C] mt-1">Sumbu X: Harga (Rp) | Sumbu Y: Volume (Unit) | Ukuran: Margin (%)</p>
        </div>
        <div class="chart-body my-4 min-h-[320px] flex items-center justify-center"></div>
        <div class="bg-[#F0FDF9] border border-[#CCFBEF] rounded-xl p-3.5 text-xs text-[#0F766E] flex items-start gap-2.5">
          <span class="text-base flex-shrink-0">💡</span>
          <div class="leading-relaxed">
            <strong class="font-semibold text-[#0F766E]">Temuan Kunci:</strong>
            <span class="text-[#134E48]">Miniatur Penari Pamonte dan Jam Meja Eboni adalah produk paling menguntungkan: barangnya selalu laku terjual dan keuntungan per buahnya sangat besar (di atas 45%).</span>
          </div>
        </div>
        <div class="flex items-center justify-between pt-3 mt-4 border-t border-[#F5EFE6] text-[11px] text-[#A89F91]">
          <span>🗄️ Sumber: products & order_items</span>
          <span>18 gelembung produk</span>
        </div>
      </div>

      <!-- C10: Tren Pendapatan per Kategori (Stacked Area) -->
      <div class="lg:col-span-2 chart-card bg-white rounded-2xl border border-[#E8DCCB] shadow-sm p-6 flex flex-col justify-between hover:shadow-md transition-shadow" data-chart-id="c10">
        <div class="flex items-center justify-between pb-3 border-b border-[#F5EFE6]">
          <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-semibold bg-[#0F766E]/10 text-[#0F766E] border border-[#0F766E]/20">
            <span>📈</span><span>C10 • Stacked Area Chart</span>
          </span>
          <div class="flex items-center gap-1.5">
            <button type="button" class="btn-table-view inline-flex items-center gap-1 px-2.5 py-1 rounded-lg text-xs font-medium text-gray-700 bg-gray-50 hover:bg-gray-100 border border-gray-200 transition" title="Lihat Data Tabel">
              <span>📋</span><span>Tabel</span>
            </button>
            <a href="<?= $base ?>/api/v1/export/c10.csv" class="inline-flex items-center gap-1 px-2.5 py-1 rounded-lg text-xs font-medium text-gray-700 bg-gray-50 hover:bg-gray-100 border border-gray-200 transition" title="Unduh CSV">
              <span>📥</span><span>CSV</span>
            </a>
            <button type="button" class="inline-flex items-center justify-center w-7 h-7 rounded-lg text-xs font-medium text-gray-600 bg-gray-50 hover:bg-gray-100 border border-gray-200 transition" title="Perbesar Layar" data-action="fullscreen">
              <span>⛶</span>
            </button>
          </div>
        </div>
        <div class="mt-4">
          <h3 class="font-bold text-gray-900 text-base leading-snug">Kategori mana yang tumbuh atau menurun dari waktu ke waktu?</h3>
          <p class="chart-subtitle text-xs text-[#78716C] mt-1">Evolusi kontribusi pendapatan 5 kategori kerajinan eboni 2023–2026</p>
        </div>
        <div class="chart-body my-4 min-h-[340px] flex items-center justify-center"></div>
        <div class="bg-[#F0FDF9] border border-[#CCFBEF] rounded-xl p-3.5 text-xs text-[#0F766E] flex items-start gap-2.5">
          <span class="text-base flex-shrink-0">💡</span>
          <div class="leading-relaxed">
            <strong class="font-semibold text-[#0F766E]">Temuan Kunci:</strong>
            <span class="text-[#134E48]">Cinderamata kecil dan perhiasan eboni adalah barang yang penjualannya naik paling cepat, terutama sejak makin banyak wisatawan luar kota datang berlibur ke Palu.</span>
          </div>
        </div>
        <div class="flex items-center justify-between pt-3 mt-4 border-t border-[#F5EFE6] text-[11px] text-[#A89F91]">
          <span>🗄️ Sumber: v_sales_monthly_category</span>
          <span>46 bulan × 5 kategori</span>
        </div>
      </div>

    </div>
  </section>

  <!-- ============================================================== -->
  <!-- 3. SEKSI CHANNEL & WILAYAH (C11 - C14) -->
  <!-- ============================================================== -->
  <section id="section-channel" class="dashboard-section space-y-6" data-section="channel">
    <div class="flex flex-col sm:flex-row sm:items-center justify-between pb-4 border-b border-[#EBE2D5] gap-3">
      <div>
        <div class="inline-flex items-center gap-1.5 text-xs font-bold text-[#0F766E] uppercase tracking-wider">
          <span>Bagian 3</span>
          <span>•</span>
          <span>Distribusi & Pemasaran</span>
        </div>
        <h2 class="font-serif text-2xl font-bold text-[#1C1410] mt-0.5">Saluran Pemasaran & Wilayah Pengiriman</h2>
        <p class="text-xs sm:text-sm text-[#78716C] mt-1">
          Kinerja 6 saluran penjualan, dinamika pergeseran ke marketplace digital, sebaran kota asal pembeli, serta segmentasi profil konsumen.
        </p>
      </div>
      <span class="inline-flex items-center px-3.5 py-1 rounded-full text-xs font-semibold bg-[#0F766E]/10 text-[#0F766E] border border-[#0F766E]/20 self-start sm:self-auto">
        Chart C11 – C14 (4 Chart)
      </span>
    </div>

    <div id="kpi-channel" class="grid grid-cols-2 md:grid-cols-4 gap-4"></div>

    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">

      <!-- C11: Pendapatan per Channel (Column Bar) -->
      <div class="chart-card bg-white rounded-2xl border border-[#E8DCCB] shadow-sm p-6 flex flex-col justify-between hover:shadow-md transition-shadow" data-chart-id="c11">
        <div class="flex items-center justify-between pb-3 border-b border-[#F5EFE6]">
          <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-semibold bg-[#0F766E]/10 text-[#0F766E] border border-[#0F766E]/20">
            <span>🏪</span><span>C11 • Column Bar</span>
          </span>
          <div class="flex items-center gap-1.5">
            <button type="button" class="btn-table-view inline-flex items-center gap-1 px-2.5 py-1 rounded-lg text-xs font-medium text-gray-700 bg-gray-50 hover:bg-gray-100 border border-gray-200 transition" title="Lihat Data Tabel">
              <span>📋</span><span>Tabel</span>
            </button>
            <a href="<?= $base ?>/api/v1/export/c11.csv" class="inline-flex items-center gap-1 px-2.5 py-1 rounded-lg text-xs font-medium text-gray-700 bg-gray-50 hover:bg-gray-100 border border-gray-200 transition" title="Unduh CSV">
              <span>📥</span><span>CSV</span>
            </a>
            <button type="button" class="inline-flex items-center justify-center w-7 h-7 rounded-lg text-xs font-medium text-gray-600 bg-gray-50 hover:bg-gray-100 border border-gray-200 transition" title="Perbesar Layar" data-action="fullscreen">
              <span>⛶</span>
            </button>
          </div>
        </div>
        <div class="mt-4">
          <h3 class="font-bold text-gray-900 text-base leading-snug">Saluran pemasaran mana yang paling produktif menghasilkan omzet?</h3>
          <p class="chart-subtitle text-xs text-[#78716C] mt-1">Total perolehan omzet pada 6 saluran penjualan</p>
        </div>
        <div class="chart-body my-4 min-h-[320px] flex items-center justify-center"></div>
        <div class="bg-[#F0FDF9] border border-[#CCFBEF] rounded-xl p-3.5 text-xs text-[#0F766E] flex items-start gap-2.5">
          <span class="text-base flex-shrink-0">💡</span>
          <div class="leading-relaxed">
            <strong class="font-semibold text-[#0F766E]">Temuan Kunci:</strong>
            <span class="text-[#134E48]">Toko galeri fisik di Palu masih menjadi tempat belanja nomor satu, namun penjualan lewat toko online (Tokopedia dan Shopee) sekarang sudah berkembang pesat menyusul toko fisik.</span>
          </div>
        </div>
        <div class="flex items-center justify-between pt-3 mt-4 border-t border-[#F5EFE6] text-[11px] text-[#A89F91]">
          <span>🗄️ Sumber: channels & orders</span>
          <span>6 kanal penjualan</span>
        </div>
      </div>

      <!-- C12: Pergeseran Porsi Channel (100% Stacked Column) -->
      <div class="chart-card bg-white rounded-2xl border border-[#E8DCCB] shadow-sm p-6 flex flex-col justify-between hover:shadow-md transition-shadow" data-chart-id="c12">
        <div class="flex items-center justify-between pb-3 border-b border-[#F5EFE6]">
          <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-semibold bg-[#0F766E]/10 text-[#0F766E] border border-[#0F766E]/20">
            <span>📊</span><span>C12 • 100% Stacked Column</span>
          </span>
          <div class="flex items-center gap-1.5">
            <button type="button" class="btn-table-view inline-flex items-center gap-1 px-2.5 py-1 rounded-lg text-xs font-medium text-gray-700 bg-gray-50 hover:bg-gray-100 border border-gray-200 transition" title="Lihat Data Tabel">
              <span>📋</span><span>Tabel</span>
            </button>
            <a href="<?= $base ?>/api/v1/export/c12.csv" class="inline-flex items-center gap-1 px-2.5 py-1 rounded-lg text-xs font-medium text-gray-700 bg-gray-50 hover:bg-gray-100 border border-gray-200 transition" title="Unduh CSV">
              <span>📥</span><span>CSV</span>
            </a>
            <button type="button" class="inline-flex items-center justify-center w-7 h-7 rounded-lg text-xs font-medium text-gray-600 bg-gray-50 hover:bg-gray-100 border border-gray-200 transition" title="Perbesar Layar" data-action="fullscreen">
              <span>⛶</span>
            </button>
          </div>
        </div>
        <div class="mt-4">
          <h3 class="font-bold text-gray-900 text-base leading-snug">Apakah penjualan bertransformasi dari toko fisik ke digital?</h3>
          <p class="chart-subtitle text-xs text-[#78716C] mt-1">Pergeseran persentase pangsa pasar saluran dari tahun 2023 ke 2026</p>
        </div>
        <div class="chart-body my-4 min-h-[320px] flex items-center justify-center"></div>
        <div class="bg-[#F0FDF9] border border-[#CCFBEF] rounded-xl p-3.5 text-xs text-[#0F766E] flex items-start gap-2.5">
          <span class="text-base flex-shrink-0">💡</span>
          <div class="leading-relaxed">
            <strong class="font-semibold text-[#0F766E]">Temuan Kunci:</strong>
            <span class="text-[#134E48]">Dulu orang hanya belanja langsung di toko fisik, namun sekarang hampir separuh pembeli (44%) sudah beralih membeli kerajinan eboni secara online lewat internet.</span>
          </div>
        </div>
        <div class="flex items-center justify-between pt-3 mt-4 border-t border-[#F5EFE6] text-[11px] text-[#A89F91]">
          <span>🗄️ Sumber: orders & channels</span>
          <span>4 tahun (2023-2026)</span>
        </div>
      </div>

      <!-- C13: Pendapatan per Wilayah (Treemap) -->
      <div class="chart-card bg-white rounded-2xl border border-[#E8DCCB] shadow-sm p-6 flex flex-col justify-between hover:shadow-md transition-shadow" data-chart-id="c13">
        <div class="flex items-center justify-between pb-3 border-b border-[#F5EFE6]">
          <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-semibold bg-[#0F766E]/10 text-[#0F766E] border border-[#0F766E]/20">
            <span>🗺️</span><span>C13 • Treemap</span>
          </span>
          <div class="flex items-center gap-1.5">
            <button type="button" class="btn-table-view inline-flex items-center gap-1 px-2.5 py-1 rounded-lg text-xs font-medium text-gray-700 bg-gray-50 hover:bg-gray-100 border border-gray-200 transition" title="Lihat Data Tabel">
              <span>📋</span><span>Tabel</span>
            </button>
            <a href="<?= $base ?>/api/v1/export/c13.csv" class="inline-flex items-center gap-1 px-2.5 py-1 rounded-lg text-xs font-medium text-gray-700 bg-gray-50 hover:bg-gray-100 border border-gray-200 transition" title="Unduh CSV">
              <span>📥</span><span>CSV</span>
            </a>
            <button type="button" class="inline-flex items-center justify-center w-7 h-7 rounded-lg text-xs font-medium text-gray-600 bg-gray-50 hover:bg-gray-100 border border-gray-200 transition" title="Perbesar Layar" data-action="fullscreen">
              <span>⛶</span>
            </button>
          </div>
        </div>
        <div class="mt-4">
          <h3 class="font-bold text-gray-900 text-base leading-snug">Dari mana pembeli berasal (Palu, Sulteng, atau luar pulau)?</h3>
          <p class="chart-subtitle text-xs text-[#78716C] mt-1">Hierarki persebaran omzet berdasarkan wilayah pengiriman</p>
        </div>
        <div class="chart-body my-4 min-h-[320px] flex items-center justify-center"></div>
        <div class="bg-[#F0FDF9] border border-[#CCFBEF] rounded-xl p-3.5 text-xs text-[#0F766E] flex items-start gap-2.5">
          <span class="text-base flex-shrink-0">💡</span>
          <div class="leading-relaxed">
            <strong class="font-semibold text-[#0F766E]">Temuan Kunci:</strong>
            <span class="text-[#134E48]">Kerajinan eboni khas Palu sangat disukai orang luar pulau. Pembeli terbanyak dari luar Sulawesi Tengah berasal dari Jakarta, Surabaya, dan Makassar.</span>
          </div>
        </div>
        <div class="flex items-center justify-between pt-3 mt-4 border-t border-[#F5EFE6] text-[11px] text-[#A89F91]">
          <span>🗄️ Sumber: regions & orders</span>
          <span>11 wilayah</span>
        </div>
      </div>

      <!-- C14: Segmentasi Profil Pembeli (Pie Chart) -->
      <div class="chart-card bg-white rounded-2xl border border-[#E8DCCB] shadow-sm p-6 flex flex-col justify-between hover:shadow-md transition-shadow" data-chart-id="c14">
        <div class="flex items-center justify-between pb-3 border-b border-[#F5EFE6]">
          <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-semibold bg-[#0F766E]/10 text-[#0F766E] border border-[#0F766E]/20">
            <span>🥧</span><span>C14 • Pie Chart</span>
          </span>
          <div class="flex items-center gap-1.5">
            <button type="button" class="btn-table-view inline-flex items-center gap-1 px-2.5 py-1 rounded-lg text-xs font-medium text-gray-700 bg-gray-50 hover:bg-gray-100 border border-gray-200 transition" title="Lihat Data Tabel">
              <span>📋</span><span>Tabel</span>
            </button>
            <a href="<?= $base ?>/api/v1/export/c14.csv" class="inline-flex items-center gap-1 px-2.5 py-1 rounded-lg text-xs font-medium text-gray-700 bg-gray-50 hover:bg-gray-100 border border-gray-200 transition" title="Unduh CSV">
              <span>📥</span><span>CSV</span>
            </a>
            <button type="button" class="inline-flex items-center justify-center w-7 h-7 rounded-lg text-xs font-medium text-gray-600 bg-gray-50 hover:bg-gray-100 border border-gray-200 transition" title="Perbesar Layar" data-action="fullscreen">
              <span>⛶</span>
            </button>
          </div>
        </div>
        <div class="mt-4">
          <h3 class="font-bold text-gray-900 text-base leading-snug">Siapa segmen target pelanggan utama kerajinan eboni?</h3>
          <p class="chart-subtitle text-xs text-[#78716C] mt-1">Proporsi pembeli: Wisatawan, Kolektor, Instansi Dinas, Korporat & Reseller</p>
        </div>
        <div class="chart-body my-4 min-h-[320px] flex items-center justify-center"></div>
        <div class="bg-[#F0FDF9] border border-[#CCFBEF] rounded-xl p-3.5 text-xs text-[#0F766E] flex items-start gap-2.5">
          <span class="text-base flex-shrink-0">💡</span>
          <div class="leading-relaxed">
            <strong class="font-semibold text-[#0F766E]">Temuan Kunci:</strong>
            <span class="text-[#134E48]">Pembeli utama kerajinan eboni adalah para wisatawan yang berlibur dan kantor-kantor dinas pemerintah yang sering memesan plakat dalam jumlah banyak untuk tamu daerah.</span>
          </div>
        </div>
        <div class="flex items-center justify-between pt-3 mt-4 border-t border-[#F5EFE6] text-[11px] text-[#A89F91]">
          <span>🗄️ Sumber: customer_segments</span>
          <span>5 segmen pasar</span>
        </div>
      </div>

    </div>
  </section>

  <!-- ============================================================== -->
  <!-- 4. SEKSI PERILAKU PELANGGAN & TRANSAKSI (C15 - C18) -->
  <!-- ============================================================== -->
  <section id="section-pelanggan" class="dashboard-section space-y-6" data-section="pelanggan">
    <div class="flex flex-col sm:flex-row sm:items-center justify-between pb-4 border-b border-[#EBE2D5] gap-3">
      <div>
        <div class="inline-flex items-center gap-1.5 text-xs font-bold text-[#0F766E] uppercase tracking-wider">
          <span>Bagian 4</span>
          <span>•</span>
          <span>Retensi & Transaksi</span>
        </div>
        <h2 class="font-serif text-2xl font-bold text-[#1C1410] mt-0.5">Perilaku Konsumen & Karakteristik Transaksi</h2>
        <p class="text-xs sm:text-sm text-[#78716C] mt-1">
          Dinamika pesanan pelanggan baru vs repeat order, distribusi nilai keranjang belanja, adopsi QRIS digital, serta pertumbuhan nilai rata-rata order (AOV).
        </p>
      </div>
      <span class="inline-flex items-center px-3.5 py-1 rounded-full text-xs font-semibold bg-[#0F766E]/10 text-[#0F766E] border border-[#0F766E]/20 self-start sm:self-auto">
        Chart C15 – C18 (4 Chart)
      </span>
    </div>

    <div id="kpi-pelanggan" class="grid grid-cols-2 md:grid-cols-4 gap-4"></div>

    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">

      <!-- C15: Pelanggan Baru vs Repeat Order (Stacked Column) -->
      <div class="chart-card bg-white rounded-2xl border border-[#E8DCCB] shadow-sm p-6 flex flex-col justify-between hover:shadow-md transition-shadow" data-chart-id="c15">
        <div class="flex items-center justify-between pb-3 border-b border-[#F5EFE6]">
          <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-semibold bg-[#0F766E]/10 text-[#0F766E] border border-[#0F766E]/20">
            <span>👥</span><span>C15 • Stacked Column</span>
          </span>
          <div class="flex items-center gap-1.5">
            <button type="button" class="btn-table-view inline-flex items-center gap-1 px-2.5 py-1 rounded-lg text-xs font-medium text-gray-700 bg-gray-50 hover:bg-gray-100 border border-gray-200 transition" title="Lihat Data Tabel">
              <span>📋</span><span>Tabel</span>
            </button>
            <a href="<?= $base ?>/api/v1/export/c15.csv" class="inline-flex items-center gap-1 px-2.5 py-1 rounded-lg text-xs font-medium text-gray-700 bg-gray-50 hover:bg-gray-100 border border-gray-200 transition" title="Unduh CSV">
              <span>📥</span><span>CSV</span>
            </a>
            <button type="button" class="inline-flex items-center justify-center w-7 h-7 rounded-lg text-xs font-medium text-gray-600 bg-gray-50 hover:bg-gray-100 border border-gray-200 transition" title="Perbesar Layar" data-action="fullscreen">
              <span>⛶</span>
            </button>
          </div>
        </div>
        <div class="mt-4">
          <h3 class="font-bold text-gray-900 text-base leading-snug">Apakah loyalitas dan repeat order pelanggan mengalami kenaikan?</h3>
          <p class="chart-subtitle text-xs text-[#78716C] mt-1">Komparasi jumlah order dari pelanggan baru vs pelanggan lama bulanan</p>
        </div>
        <div class="chart-body my-4 min-h-[320px] flex items-center justify-center"></div>
        <div class="bg-[#F0FDF9] border border-[#CCFBEF] rounded-xl p-3.5 text-xs text-[#0F766E] flex items-start gap-2.5">
          <span class="text-base flex-shrink-0">💡</span>
          <div class="leading-relaxed">
            <strong class="font-semibold text-[#0F766E]">Temuan Kunci:</strong>
            <span class="text-[#134E48]">Banyak pembeli yang puas dan kembali membeli lagi (sekitar 1 dari 4 transaksi). Pelanggan yang paling setia memesan ulang adalah kantor instansi dinas pemerintah.</span>
          </div>
        </div>
        <div class="flex items-center justify-between pt-3 mt-4 border-t border-[#F5EFE6] text-[11px] text-[#A89F91]">
          <span>🗄️ Sumber: orders & customers</span>
          <span>46 bulan</span>
        </div>
      </div>

      <!-- C17: Metode Pembayaran (Radial Bar) -->
      <div class="chart-card bg-white rounded-2xl border border-[#E8DCCB] shadow-sm p-6 flex flex-col justify-between hover:shadow-md transition-shadow" data-chart-id="c17">
        <div class="flex items-center justify-between pb-3 border-b border-[#F5EFE6]">
          <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-semibold bg-[#0F766E]/10 text-[#0F766E] border border-[#0F766E]/20">
            <span>💳</span><span>C17 • Radial Bar</span>
          </span>
          <div class="flex items-center gap-1.5">
            <button type="button" class="btn-table-view inline-flex items-center gap-1 px-2.5 py-1 rounded-lg text-xs font-medium text-gray-700 bg-gray-50 hover:bg-gray-100 border border-gray-200 transition" title="Lihat Data Tabel">
              <span>📋</span><span>Tabel</span>
            </button>
            <a href="<?= $base ?>/api/v1/export/c17.csv" class="inline-flex items-center gap-1 px-2.5 py-1 rounded-lg text-xs font-medium text-gray-700 bg-gray-50 hover:bg-gray-100 border border-gray-200 transition" title="Unduh CSV">
              <span>📥</span><span>CSV</span>
            </a>
            <button type="button" class="inline-flex items-center justify-center w-7 h-7 rounded-lg text-xs font-medium text-gray-600 bg-gray-50 hover:bg-gray-100 border border-gray-200 transition" title="Perbesar Layar" data-action="fullscreen">
              <span>⛶</span>
            </button>
          </div>
        </div>
        <div class="mt-4">
          <h3 class="font-bold text-gray-900 text-base leading-snug">Metode pembayaran apa yang paling dominan digunakan pembeli?</h3>
          <p class="chart-subtitle text-xs text-[#78716C] mt-1">Persentase adopsi pembayaran: QRIS, Transfer Bank, Saldo Marketplace & Tunai</p>
        </div>
        <div class="chart-body my-4 min-h-[320px] flex items-center justify-center"></div>
        <div class="bg-[#F0FDF9] border border-[#CCFBEF] rounded-xl p-3.5 text-xs text-[#0F766E] flex items-start gap-2.5">
          <span class="text-base flex-shrink-0">💡</span>
          <div class="leading-relaxed">
            <strong class="font-semibold text-[#0F766E]">Temuan Kunci:</strong>
            <span class="text-[#134E48]">Sebagian besar pembeli (65%) sekarang lebih suka membayar secara nontunai menggunakan scan QRIS dan aplikasi online, sehingga uang pembayaran langsung masuk aman ke rekening toko.</span>
          </div>
        </div>
        <div class="flex items-center justify-between pt-3 mt-4 border-t border-[#F5EFE6] text-[11px] text-[#A89F91]">
          <span>🗄️ Sumber: orders (payment_methods)</span>
          <span>5 kanal bayar</span>
        </div>
      </div>

      <!-- C16: Distribusi Nilai Transaksi (Histogram Bar) -->
      <div class="chart-card bg-white rounded-2xl border border-[#E8DCCB] shadow-sm p-6 flex flex-col justify-between hover:shadow-md transition-shadow" data-chart-id="c16">
        <div class="flex items-center justify-between pb-3 border-b border-[#F5EFE6]">
          <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-semibold bg-[#0F766E]/10 text-[#0F766E] border border-[#0F766E]/20">
            <span>📊</span><span>C16 • Histogram Bar</span>
          </span>
          <div class="flex items-center gap-1.5">
            <button type="button" class="btn-table-view inline-flex items-center gap-1 px-2.5 py-1 rounded-lg text-xs font-medium text-gray-700 bg-gray-50 hover:bg-gray-100 border border-gray-200 transition" title="Lihat Data Tabel">
              <span>📋</span><span>Tabel</span>
            </button>
            <a href="<?= $base ?>/api/v1/export/c16.csv" class="inline-flex items-center gap-1 px-2.5 py-1 rounded-lg text-xs font-medium text-gray-700 bg-gray-50 hover:bg-gray-100 border border-gray-200 transition" title="Unduh CSV">
              <span>📥</span><span>CSV</span>
            </a>
            <button type="button" class="inline-flex items-center justify-center w-7 h-7 rounded-lg text-xs font-medium text-gray-600 bg-gray-50 hover:bg-gray-100 border border-gray-200 transition" title="Perbesar Layar" data-action="fullscreen">
              <span>⛶</span>
            </button>
          </div>
        </div>
        <div class="mt-4">
          <h3 class="font-bold text-gray-900 text-base leading-snug">Rentang nilai belanja mana yang paling sering dilakukan pembeli?</h3>
          <p class="chart-subtitle text-xs text-[#78716C] mt-1">Frekuensi pesanan berdasarkan klasifikasi rentang nominal belanja</p>
        </div>
        <div class="chart-body my-4 min-h-[320px] flex items-center justify-center"></div>
        <div class="bg-[#F0FDF9] border border-[#CCFBEF] rounded-xl p-3.5 text-xs text-[#0F766E] flex items-start gap-2.5">
          <span class="text-base flex-shrink-0">💡</span>
          <div class="leading-relaxed">
            <strong class="font-semibold text-[#0F766E]">Temuan Kunci:</strong>
            <span class="text-[#134E48]">Kebanyakan orang paling sering berbelanja oleh-oleh dengan harga Rp 100 ribu sampai Rp 300 ribu. Ini patokan harga paling pas jika ingin membuat paket cenderamata turis.</span>
          </div>
        </div>
        <div class="flex items-center justify-between pt-3 mt-4 border-t border-[#F5EFE6] text-[11px] text-[#A89F91]">
          <span>🗄️ Sumber: orders</span>
          <span>6 rentang nilai</span>
        </div>
      </div>

      <!-- C18: Tren Nilai Rata-rata Pesanan / AOV (Line Chart) -->
      <div class="chart-card bg-white rounded-2xl border border-[#E8DCCB] shadow-sm p-6 flex flex-col justify-between hover:shadow-md transition-shadow" data-chart-id="c18">
        <div class="flex items-center justify-between pb-3 border-b border-[#F5EFE6]">
          <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-semibold bg-[#0F766E]/10 text-[#0F766E] border border-[#0F766E]/20">
            <span>📈</span><span>C18 • Line Chart</span>
          </span>
          <div class="flex items-center gap-1.5">
            <button type="button" class="btn-table-view inline-flex items-center gap-1 px-2.5 py-1 rounded-lg text-xs font-medium text-gray-700 bg-gray-50 hover:bg-gray-100 border border-gray-200 transition" title="Lihat Data Tabel">
              <span>📋</span><span>Tabel</span>
            </button>
            <a href="<?= $base ?>/api/v1/export/c18.csv" class="inline-flex items-center gap-1 px-2.5 py-1 rounded-lg text-xs font-medium text-gray-700 bg-gray-50 hover:bg-gray-100 border border-gray-200 transition" title="Unduh CSV">
              <span>📥</span><span>CSV</span>
            </a>
            <button type="button" class="inline-flex items-center justify-center w-7 h-7 rounded-lg text-xs font-medium text-gray-600 bg-gray-50 hover:bg-gray-100 border border-gray-200 transition" title="Perbesar Layar" data-action="fullscreen">
              <span>⛶</span>
            </button>
          </div>
        </div>
        <div class="mt-4">
          <h3 class="font-bold text-gray-900 text-base leading-snug">Apakah nilai belanja per invoice (AOV) terus bertumbuh?</h3>
          <p class="chart-subtitle text-xs text-[#78716C] mt-1">Tren rata-rata nilai pesanan pelanggan (Rupiah per transaksi)</p>
        </div>
        <div class="chart-body my-4 min-h-[320px] flex items-center justify-center"></div>
        <div class="bg-[#F0FDF9] border border-[#CCFBEF] rounded-xl p-3.5 text-xs text-[#0F766E] flex items-start gap-2.5">
          <span class="text-base flex-shrink-0">💡</span>
          <div class="leading-relaxed">
            <strong class="font-semibold text-[#0F766E]">Temuan Kunci:</strong>
            <span class="text-[#134E48]">Rata-rata uang yang dibelanjakan setiap pembeli terus naik (dari Rp 280 ribu menjadi Rp 395 ribu), karena toko pintar memaketkan beberapa barang sekaligus.</span>
          </div>
        </div>
        <div class="flex items-center justify-between pt-3 mt-4 border-t border-[#F5EFE6] text-[11px] text-[#A89F91]">
          <span>🗄️ Sumber: v_sales_monthly</span>
          <span>46 bulan</span>
        </div>
      </div>

    </div>
  </section>

  <!-- ============================================================== -->
  <!-- 5. SEKSI OPERASIONAL & BIAYA (C19 - C21) -->
  <!-- ============================================================== -->
  <section id="section-operasional" class="dashboard-section space-y-6" data-section="operasional">
    <div class="flex flex-col sm:flex-row sm:items-center justify-between pb-4 border-b border-[#EBE2D5] gap-3">
      <div>
        <div class="inline-flex items-center gap-1.5 text-xs font-bold text-[#0F766E] uppercase tracking-wider">
          <span>Bagian 5</span>
          <span>•</span>
          <span>Produksi & Logistik</span>
        </div>
        <h2 class="font-serif text-2xl font-bold text-[#1C1410] mt-0.5">Operasional Bengkel Kerja, Biaya & Stok</h2>
        <p class="text-xs sm:text-sm text-[#78716C] mt-1">
          Keseimbangan persediaan terhadap permintaan pasar, rincian biaya HPP kayu eboni, serta sebaran lead time pembuatan ukiran.
        </p>
      </div>
      <span class="inline-flex items-center px-3.5 py-1 rounded-full text-xs font-semibold bg-[#0F766E]/10 text-[#0F766E] border border-[#0F766E]/20 self-start sm:self-auto">
        Chart C19 – C21 (3 Chart)
      </span>
    </div>

    <div id="kpi-operasional" class="grid grid-cols-2 md:grid-cols-4 gap-4"></div>

    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">

      <!-- C19: Stok Akhir vs Unit Terjual (Combo Area + Column) -->
      <div class="lg:col-span-2 chart-card bg-white rounded-2xl border border-[#E8DCCB] shadow-sm p-6 flex flex-col justify-between hover:shadow-md transition-shadow" data-chart-id="c19">
        <div class="flex items-center justify-between pb-3 border-b border-[#F5EFE6]">
          <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-semibold bg-[#0F766E]/10 text-[#0F766E] border border-[#0F766E]/20">
            <span>📦</span><span>C19 • Combo (Area + Column)</span>
          </span>
          <div class="flex items-center gap-1.5">
            <button type="button" class="btn-table-view inline-flex items-center gap-1 px-2.5 py-1 rounded-lg text-xs font-medium text-gray-700 bg-gray-50 hover:bg-gray-100 border border-gray-200 transition" title="Lihat Data Tabel">
              <span>📋</span><span>Tabel</span>
            </button>
            <a href="<?= $base ?>/api/v1/export/c19.csv" class="inline-flex items-center gap-1 px-2.5 py-1 rounded-lg text-xs font-medium text-gray-700 bg-gray-50 hover:bg-gray-100 border border-gray-200 transition" title="Unduh CSV">
              <span>📥</span><span>CSV</span>
            </a>
            <button type="button" class="inline-flex items-center justify-center w-7 h-7 rounded-lg text-xs font-medium text-gray-600 bg-gray-50 hover:bg-gray-100 border border-gray-200 transition" title="Perbesar Layar" data-action="fullscreen">
              <span>⛶</span>
            </button>
          </div>
        </div>
        <div class="mt-4">
          <h3 class="font-bold text-gray-900 text-base leading-snug">Apakah persediaan stok gudang selaras dengan laju penjualan nyata?</h3>
          <p class="chart-subtitle text-xs text-[#78716C] mt-1">Bidang Area: Stok Akhir Gudang | Diagram Batang: Unit Terjual Bulanan</p>
        </div>
        <div class="chart-body my-4 min-h-[340px] flex items-center justify-center"></div>
        <div class="bg-[#F0FDF9] border border-[#CCFBEF] rounded-xl p-3.5 text-xs text-[#0F766E] flex items-start gap-2.5">
          <span class="text-base flex-shrink-0">💡</span>
          <div class="leading-relaxed">
            <strong class="font-semibold text-[#0F766E]">Temuan Kunci:</strong>
            <span class="text-[#134E48]">Persediaan barang jadi di gudang selalu aman dan cukup, sehingga toko tidak pernah kehabisan stok saat ada pameran seni atau lonjakan pembeli di hari libur.</span>
          </div>
        </div>
        <div class="flex items-center justify-between pt-3 mt-4 border-t border-[#F5EFE6] text-[11px] text-[#A89F91]">
          <span>🗄️ Sumber: inventory_snapshots & orders</span>
          <span>46 bulan komparasi</span>
        </div>
      </div>

      <!-- C20: Struktur Biaya Usaha per Tahun (100% Horizontal Stacked Bar) -->
      <div class="chart-card bg-white rounded-2xl border border-[#E8DCCB] shadow-sm p-6 flex flex-col justify-between hover:shadow-md transition-shadow" data-chart-id="c20">
        <div class="flex items-center justify-between pb-3 border-b border-[#F5EFE6]">
          <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-semibold bg-[#0F766E]/10 text-[#0F766E] border border-[#0F766E]/20">
            <span>💰</span><span>C20 • 100% Horizontal Stacked Bar</span>
          </span>
          <div class="flex items-center gap-1.5">
            <button type="button" class="btn-table-view inline-flex items-center gap-1 px-2.5 py-1 rounded-lg text-xs font-medium text-gray-700 bg-gray-50 hover:bg-gray-100 border border-gray-200 transition" title="Lihat Data Tabel">
              <span>📋</span><span>Tabel</span>
            </button>
            <a href="<?= $base ?>/api/v1/export/c20.csv" class="inline-flex items-center gap-1 px-2.5 py-1 rounded-lg text-xs font-medium text-gray-700 bg-gray-50 hover:bg-gray-100 border border-gray-200 transition" title="Unduh CSV">
              <span>📥</span><span>CSV</span>
            </a>
            <button type="button" class="inline-flex items-center justify-center w-7 h-7 rounded-lg text-xs font-medium text-gray-600 bg-gray-50 hover:bg-gray-100 border border-gray-200 transition" title="Perbesar Layar" data-action="fullscreen">
              <span>⛶</span>
            </button>
          </div>
        </div>
        <div class="mt-4">
          <h3 class="font-bold text-gray-900 text-base leading-snug">Komponen biaya mana yang paling besar menyerap anggaran usaha?</h3>
          <p class="chart-subtitle text-xs text-[#78716C] mt-1">Struktur biaya: Kayu Eboni Legal, Upah Pengrajin, Finishing & Operasional</p>
        </div>
        <div class="chart-body my-4 min-h-[320px] flex items-center justify-center"></div>
        <div class="bg-[#F0FDF9] border border-[#CCFBEF] rounded-xl p-3.5 text-xs text-[#0F766E] flex items-start gap-2.5">
          <span class="text-base flex-shrink-0">💡</span>
          <div class="leading-relaxed">
            <strong class="font-semibold text-[#0F766E]">Temuan Kunci:</strong>
            <span class="text-[#134E48]">Pengeluaran terbesar dalam usaha ini adalah membeli kayu eboni hitam yang legal dan membayar upah tukang ukir ahli (mencapai lebih dari dua pertiga modal produksi).</span>
          </div>
        </div>
        <div class="flex items-center justify-between pt-3 mt-4 border-t border-[#F5EFE6] text-[11px] text-[#A89F91]">
          <span>🗄️ Sumber: cost_breakdowns</span>
          <span>4 tahun (2023-2026)</span>
        </div>
      </div>

      <!-- C21: Boxplot Lead Time Produksi (Boxplot) -->
      <div class="chart-card bg-white rounded-2xl border border-[#E8DCCB] shadow-sm p-6 flex flex-col justify-between hover:shadow-md transition-shadow" data-chart-id="c21">
        <div class="flex items-center justify-between pb-3 border-b border-[#F5EFE6]">
          <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-semibold bg-[#0F766E]/10 text-[#0F766E] border border-[#0F766E]/20">
            <span>⏱️</span><span>C21 • Boxplot</span>
          </span>
          <div class="flex items-center gap-1.5">
            <button type="button" class="btn-table-view inline-flex items-center gap-1 px-2.5 py-1 rounded-lg text-xs font-medium text-gray-700 bg-gray-50 hover:bg-gray-100 border border-gray-200 transition" title="Lihat Data Tabel">
              <span>📋</span><span>Tabel</span>
            </button>
            <a href="<?= $base ?>/api/v1/export/c21.csv" class="inline-flex items-center gap-1 px-2.5 py-1 rounded-lg text-xs font-medium text-gray-700 bg-gray-50 hover:bg-gray-100 border border-gray-200 transition" title="Unduh CSV">
              <span>📥</span><span>CSV</span>
            </a>
            <button type="button" class="inline-flex items-center justify-center w-7 h-7 rounded-lg text-xs font-medium text-gray-600 bg-gray-50 hover:bg-gray-100 border border-gray-200 transition" title="Perbesar Layar" data-action="fullscreen">
              <span>⛶</span>
            </button>
          </div>
        </div>
        <div class="mt-4">
          <h3 class="font-bold text-gray-900 text-base leading-snug">Berapa lama estimasi pengerjaan pesanan per kategori kerajinan?</h3>
          <p class="chart-subtitle text-xs text-[#78716C] mt-1">Distribusi sebaran hari pembuatan: Min, Q1, Median, Q3, dan Nilai Maksimum</p>
        </div>
        <div class="chart-body my-4 min-h-[320px] flex items-center justify-center"></div>
        <div class="bg-[#F0FDF9] border border-[#CCFBEF] rounded-xl p-3.5 text-xs text-[#0F766E] flex items-start gap-2.5">
          <span class="text-base flex-shrink-0">💡</span>
          <div class="leading-relaxed">
            <strong class="font-semibold text-[#0F766E]">Temuan Kunci:</strong>
            <span class="text-[#134E48]">Membuat patung ukir eboni butuh waktu pengerjaan rata-rata 16 hari kerja. Jika ingin memesan patung untuk acara khusus, pesanlah minimal 3 minggu sebelumnya.</span>
          </div>
        </div>
        <div class="flex items-center justify-between pt-3 mt-4 border-t border-[#F5EFE6] text-[11px] text-[#A89F91]">
          <span>🗄️ Sumber: production_batches</span>
          <span>5 kategori produk</span>
        </div>
      </div>

    </div>
  </section>

  <!-- ============================================================== -->
  <!-- 6. SEKSI PREDIKSI PENJUALAN 12 BULAN (C22 - C25) -->
  <!-- ============================================================== -->
  <section id="section-prediksi" class="dashboard-section space-y-6" data-section="prediksi">
    <div class="flex flex-col sm:flex-row sm:items-center justify-between pb-4 border-b border-[#EBE2D5] gap-3">
      <div>
        <div class="inline-flex items-center gap-1.5 text-xs font-bold text-[#0F766E] uppercase tracking-wider">
          <span>Bagian 6</span>
          <span>•</span>
          <span>Peramalan & Jadwal Produksi</span>
        </div>
        <h2 class="font-serif text-2xl font-bold text-[#1C1410] mt-0.5">Prediksi Penjualan 12 Bulan Mendatang</h2>
        <p class="text-xs sm:text-sm text-[#78716C] mt-1">
          Proyeksi algoritma Holt-Winters, evaluasi backtest 3 model (Aktual vs Model), interval keyakinan 95%, dan panduan kebutuhan stok bahan baku.
        </p>
      </div>
      <span class="inline-flex items-center px-3.5 py-1 rounded-full text-xs font-semibold bg-[#0F766E]/10 text-[#0F766E] border border-[#0F766E]/20 self-start sm:self-auto">
        Chart C22 – C25 (4 Chart)
      </span>
    </div>

    <div id="kpi-prediksi" class="grid grid-cols-2 md:grid-cols-4 gap-4"></div>

    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">

      <!-- C22: Prediksi Pendapatan 12 Bulan + Interval 95% -->
      <div class="lg:col-span-2 chart-card bg-white rounded-2xl border border-[#E8DCCB] shadow-sm p-6 flex flex-col justify-between hover:shadow-md transition-shadow" data-chart-id="c22">
        <div class="flex items-center justify-between pb-3 border-b border-[#F5EFE6]">
          <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-semibold bg-[#0F766E]/10 text-[#0F766E] border border-[#0F766E]/20">
            <span>🔮</span><span>C22 • Multi-line + Interval 95%</span>
          </span>
          <div class="flex items-center gap-1.5">
            <button type="button" class="btn-table-view inline-flex items-center gap-1 px-2.5 py-1 rounded-lg text-xs font-medium text-gray-700 bg-gray-50 hover:bg-gray-100 border border-gray-200 transition" title="Lihat Data Tabel">
              <span>📋</span><span>Tabel</span>
            </button>
            <a href="<?= $base ?>/api/v1/export/c22.csv" class="inline-flex items-center gap-1 px-2.5 py-1 rounded-lg text-xs font-medium text-gray-700 bg-gray-50 hover:bg-gray-100 border border-gray-200 transition" title="Unduh CSV">
              <span>📥</span><span>CSV</span>
            </a>
            <button type="button" class="inline-flex items-center justify-center w-7 h-7 rounded-lg text-xs font-medium text-gray-600 bg-gray-50 hover:bg-gray-100 border border-gray-200 transition" title="Perbesar Layar" data-action="fullscreen">
              <span>⛶</span>
            </button>
          </div>
        </div>
        <div class="mt-4">
          <h3 class="font-bold text-gray-900 text-base leading-snug">Berapa estimasi omzet 12 bulan mendatang dan batas kepastiannya?</h3>
          <p class="chart-subtitle text-xs text-[#78716C] mt-1">Garis Hijau: Aktual | Garis Oranye: Prediksi Holt-Winters | Garis Biru Putus-Putus: Rentang Batas Atas & Bawah 95%</p>
        </div>
        <div class="chart-body my-4 min-h-[350px] flex items-center justify-center"></div>
        <div class="bg-[#F0FDF9] border border-[#CCFBEF] rounded-xl p-3.5 text-xs text-[#0F766E] flex items-start gap-2.5">
          <span class="text-base flex-shrink-0">💡</span>
          <div class="leading-relaxed">
            <strong class="font-semibold text-[#0F766E]">Temuan Kunci:</strong>
            <span class="text-[#134E48]">Diperkirakan total penjualan selama 12 bulan ke depan tembus Rp 412,8 Juta, dengan bulan Desember sebagai bulan paling laris dan menghasilkan uang terbanyak.</span>
          </div>
        </div>
        <div class="flex items-center justify-between pt-3 mt-4 border-t border-[#F5EFE6] text-[11px] text-[#A89F91]">
          <span>🗄️ Sumber: forecast_monthly_summary</span>
          <span>12 bulan proyeksi</span>
        </div>
      </div>

      <!-- C23: Uji Mundur Aktual vs 3 Model (Multi-line) -->
      <div class="chart-card bg-white rounded-2xl border border-[#E8DCCB] shadow-sm p-6 flex flex-col justify-between hover:shadow-md transition-shadow" data-chart-id="c23">
        <div class="flex items-center justify-between pb-3 border-b border-[#F5EFE6]">
          <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-semibold bg-[#0F766E]/10 text-[#0F766E] border border-[#0F766E]/20">
            <span>🧪</span><span>C23 • Multi-line Chart</span>
          </span>
          <div class="flex items-center gap-1.5">
            <button type="button" class="btn-table-view inline-flex items-center gap-1 px-2.5 py-1 rounded-lg text-xs font-medium text-gray-700 bg-gray-50 hover:bg-gray-100 border border-gray-200 transition" title="Lihat Data Tabel">
              <span>📋</span><span>Tabel</span>
            </button>
            <a href="<?= $base ?>/api/v1/export/c23.csv" class="inline-flex items-center gap-1 px-2.5 py-1 rounded-lg text-xs font-medium text-gray-700 bg-gray-50 hover:bg-gray-100 border border-gray-200 transition" title="Unduh CSV">
              <span>📥</span><span>CSV</span>
            </a>
            <button type="button" class="inline-flex items-center justify-center w-7 h-7 rounded-lg text-xs font-medium text-gray-600 bg-gray-50 hover:bg-gray-100 border border-gray-200 transition" title="Perbesar Layar" data-action="fullscreen">
              <span>⛶</span>
            </button>
          </div>
        </div>
        <div class="mt-4">
          <h3 class="font-bold text-gray-900 text-base leading-snug">Model mana yang paling akurat mereplikasi data historis nyata?</h3>
          <p class="chart-subtitle text-xs text-[#78716C] mt-1">Uji Holdout 12 Bulan: Data Nyata vs Holt-Winters vs Regresi vs SMA</p>
        </div>
        <div class="chart-body my-4 min-h-[320px] flex items-center justify-center"></div>
        <div class="bg-[#F0FDF9] border border-[#CCFBEF] rounded-xl p-3.5 text-xs text-[#0F766E] flex items-start gap-2.5">
          <span class="text-base flex-shrink-0">💡</span>
          <div class="leading-relaxed">
            <strong class="font-semibold text-[#0F766E]">Temuan Kunci:</strong>
            <span class="text-[#134E48]">Sistem komputer terbukti sangat cerdas dan tepat membaca pola naik-turunnya pembeli di musim ramai (Juli dan Desember) sehingga pemilik toko bisa bersiap lebih awal.</span>
          </div>
        </div>
        <div class="flex items-center justify-between pt-3 mt-4 border-t border-[#F5EFE6] text-[11px] text-[#A89F91]">
          <span>🗄️ Sumber: forecast_backtest_eval</span>
          <span>12 bulan holdout data</span>
        </div>
      </div>

      <!-- C24: Akurasi Model MAPE & NRMSE (Grouped Bar) -->
      <div class="chart-card bg-white rounded-2xl border border-[#E8DCCB] shadow-sm p-6 flex flex-col justify-between hover:shadow-md transition-shadow" data-chart-id="c24">
        <div class="flex items-center justify-between pb-3 border-b border-[#F5EFE6]">
          <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-semibold bg-[#0F766E]/10 text-[#0F766E] border border-[#0F766E]/20">
            <span>🎯</span><span>C24 • Grouped Bar</span>
          </span>
          <div class="flex items-center gap-1.5">
            <button type="button" class="btn-table-view inline-flex items-center gap-1 px-2.5 py-1 rounded-lg text-xs font-medium text-gray-700 bg-gray-50 hover:bg-gray-100 border border-gray-200 transition" title="Lihat Data Tabel">
              <span>📋</span><span>Tabel</span>
            </button>
            <a href="<?= $base ?>/api/v1/export/c24.csv" class="inline-flex items-center gap-1 px-2.5 py-1 rounded-lg text-xs font-medium text-gray-700 bg-gray-50 hover:bg-gray-100 border border-gray-200 transition" title="Unduh CSV">
              <span>📥</span><span>CSV</span>
            </a>
            <button type="button" class="inline-flex items-center justify-center w-7 h-7 rounded-lg text-xs font-medium text-gray-600 bg-gray-50 hover:bg-gray-100 border border-gray-200 transition" title="Perbesar Layar" data-action="fullscreen">
              <span>⛶</span>
            </button>
          </div>
        </div>
        <div class="mt-4">
          <h3 class="font-bold text-gray-900 text-base leading-snug">Seberapa kecil tingkat kesalahan (error) masing-masing model?</h3>
          <p class="chart-subtitle text-xs text-[#78716C] mt-1">Perbandingan metrik evaluasi akurasi MAPE (%) dan NRMSE (%)</p>
        </div>
        <div class="chart-body my-4 min-h-[320px] flex items-center justify-center"></div>
        <div class="bg-[#F0FDF9] border border-[#CCFBEF] rounded-xl p-3.5 text-xs text-[#0F766E] flex items-start gap-2.5">
          <span class="text-base flex-shrink-0">💡</span>
          <div class="leading-relaxed">
            <strong class="font-semibold text-[#0F766E]">Temuan Kunci:</strong>
            <span class="text-[#134E48]">Tingkat ketepatan tebakan komputer ini sangat tinggi (mencapai lebih dari 92%), sehingga pemilik toko bisa tenang dan percaya diri menggunakannya untuk belanja kayu.</span>
          </div>
        </div>
        <div class="flex items-center justify-between pt-3 mt-4 border-t border-[#F5EFE6] text-[11px] text-[#A89F91]">
          <span>🗄️ Sumber: model_evaluations</span>
          <span>3 algoritma diuji</span>
        </div>
      </div>

      <!-- C25: Prediksi per Kategori Produk (Stacked Column) -->
      <div class="lg:col-span-2 chart-card bg-white rounded-2xl border border-[#E8DCCB] shadow-sm p-6 flex flex-col justify-between hover:shadow-md transition-shadow" data-chart-id="c25">
        <div class="flex items-center justify-between pb-3 border-b border-[#F5EFE6]">
          <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-semibold bg-[#0F766E]/10 text-[#0F766E] border border-[#0F766E]/20">
            <span>📊</span><span>C25 • Stacked Column</span>
          </span>
          <div class="flex items-center gap-1.5">
            <button type="button" class="btn-table-view inline-flex items-center gap-1 px-2.5 py-1 rounded-lg text-xs font-medium text-gray-700 bg-gray-50 hover:bg-gray-100 border border-gray-200 transition" title="Lihat Data Tabel">
              <span>📋</span><span>Tabel</span>
            </button>
            <a href="<?= $base ?>/api/v1/export/c25.csv" class="inline-flex items-center gap-1 px-2.5 py-1 rounded-lg text-xs font-medium text-gray-700 bg-gray-50 hover:bg-gray-100 border border-gray-200 transition" title="Unduh CSV">
              <span>📥</span><span>CSV</span>
            </a>
            <button type="button" class="inline-flex items-center justify-center w-7 h-7 rounded-lg text-xs font-medium text-gray-600 bg-gray-50 hover:bg-gray-100 border border-gray-200 transition" title="Perbesar Layar" data-action="fullscreen">
              <span>⛶</span>
            </button>
          </div>
        </div>
        <div class="mt-4">
          <h3 class="font-bold text-gray-900 text-base leading-snug">Berapa alokasi target penjualan untuk masing-masing 5 kategori?</h3>
          <p class="chart-subtitle text-xs text-[#78716C] mt-1">Rekonsiliasi peramalan top-down 12 bulan ke depan untuk panduan bengkel kerja</p>
        </div>
        <div class="chart-body my-4 min-h-[340px] flex items-center justify-center"></div>
        <div class="bg-[#F0FDF9] border border-[#CCFBEF] rounded-xl p-3.5 text-xs text-[#0F766E] flex items-start gap-2.5">
          <span class="text-base flex-shrink-0">💡</span>
          <div class="leading-relaxed">
            <strong class="font-semibold text-[#0F766E]">Temuan Kunci:</strong>
            <span class="text-[#134E48]">Untuk setahun ke depan, patung ukir tetap akan menyumbang pemasukan terbesar (sekitar Rp 192 Juta), disusul perhiasan aksesoris dan suvenir gantungan kunci.</span>
          </div>
        </div>
        <div class="flex items-center justify-between pt-3 mt-4 border-t border-[#F5EFE6] text-[11px] text-[#A89F91]">
          <span>🗄️ Sumber: forecast_monthly_category</span>
          <span>12 bulan × 5 kategori</span>
        </div>
      </div>

    </div>

    <!-- Table: Rekomendasi Jadwal Produksi & Persediaan Kayu Eboni (12 Bulan ke Depan) -->
    <div class="bg-white rounded-2xl border border-[#E8DCCB] p-6 shadow-sm space-y-4">
      <div>
        <h3 class="font-bold text-gray-900 text-base">
          Rekomendasi Jadwal Produksi & Persediaan Kayu Eboni (12 Bulan ke Depan)
        </h3>
        <p class="text-xs text-[#78716C] mt-1">
          Diturunkan dari proyeksi pendapatan kategori, harga rata-rata, dan lead time pengerjaan (+10% safety buffer).
        </p>
      </div>

      <div class="overflow-x-auto rounded-xl border border-gray-200">
        <table class="w-full text-left text-xs border-collapse">
          <thead class="bg-[#FAF7F2] text-gray-700 font-semibold border-b border-gray-200">
            <tr>
              <th class="py-3 px-4">Kategori Kerajinan</th>
              <th class="py-3 px-4">Lead Time Rata-rata</th>
              <th class="py-3 px-4">Bulan Puncak Prediksi</th>
              <th class="py-3 px-4">Target Puncak (+10%)</th>
              <th class="py-3 px-4">Total Kebutuhan 1 Tahun</th>
              <th class="py-3 px-4">Mulai Persiapan</th>
              <th class="py-3 px-4">Rekomendasi Tindakan</th>
            </tr>
          </thead>
          <tbody class="divide-y divide-gray-100 text-gray-600">
            <tr class="hover:bg-gray-50 transition">
              <td class="py-3 px-4 font-bold text-gray-900">Aksesoris Eboni</td>
              <td class="py-3 px-4">5 hari</td>
              <td class="py-3 px-4 font-semibold text-[#0F766E]">Desember 2026</td>
              <td class="py-3 px-4">± 320 unit</td>
              <td class="py-3 px-4">± 2.450 unit</td>
              <td class="py-3 px-4">Pertengahan Nov</td>
              <td class="py-3 px-4 text-xs">Tingkatkan stok gelang eboni polos dan ukir 2 minggu sebelum liburan akhir tahun.</td>
            </tr>
            <tr class="hover:bg-gray-50 transition">
              <td class="py-3 px-4 font-bold text-gray-900">Dekorasi & Patung</td>
              <td class="py-3 px-4">16 hari</td>
              <td class="py-3 px-4 font-semibold text-[#0F766E]">Desember 2026</td>
              <td class="py-3 px-4">± 65 unit</td>
              <td class="py-3 px-4">± 480 unit</td>
              <td class="py-3 px-4">Awal November</td>
              <td class="py-3 px-4 text-xs">Wajib siapkan balok kayu eboni kering sejak Oktober untuk ukiran patung penari & adat.</td>
            </tr>
            <tr class="hover:bg-gray-50 transition">
              <td class="py-3 px-4 font-bold text-gray-900">Souvenir Khas Palu</td>
              <td class="py-3 px-4">4 hari</td>
              <td class="py-3 px-4 font-semibold text-[#0F766E]">Juli 2027</td>
              <td class="py-3 px-4">± 680 unit</td>
              <td class="py-3 px-4">± 4.900 unit</td>
              <td class="py-3 px-4">Pertengahan Juni</td>
              <td class="py-3 px-4 text-xs">Tingkatkan produksi gantungan kunci & magnet kulkas menjelang liburan sekolah.</td>
            </tr>
            <tr class="hover:bg-gray-50 transition">
              <td class="py-3 px-4 font-bold text-gray-900">Alat Tulis & Fungsional</td>
              <td class="py-3 px-4">7 hari</td>
              <td class="py-3 px-4 font-semibold text-[#0F766E]">September 2027</td>
              <td class="py-3 px-4">± 110 unit</td>
              <td class="py-3 px-4">± 890 unit</td>
              <td class="py-3 px-4">Akhir Agustus</td>
              <td class="py-3 px-4 text-xs">Siapkan kotak perhiasan dan pulpen eboni menjelang pameran kerajinan & HUT daerah.</td>
            </tr>
            <tr class="hover:bg-gray-50 transition">
              <td class="py-3 px-4 font-bold text-gray-900">Religi & Seremonial</td>
              <td class="py-3 px-4">9 hari</td>
              <td class="py-3 px-4 font-semibold text-[#0F766E]">Maret 2027</td>
              <td class="py-3 px-4">± 140 unit</td>
              <td class="py-3 px-4">± 950 unit</td>
              <td class="py-3 px-4">Februari 2027</td>
              <td class="py-3 px-4 text-xs">Tingkatkan produksi tasbih dan rehal eboni 3 minggu sebelum bulan suci Ramadan.</td>
            </tr>
          </tbody>
        </table>
      </div>
    </div>

    <!-- ============================================================== -->
    <!-- SECTION 6: KONTROL ADMIN vs PREVIEW PUBLIK TERKUNCI -->
    <!-- ============================================================== -->
    <?php if ($isAdmin): ?>
      <!-- UNLOCKED FULL ADMIN CONTROL DECK -->
      <div class="bg-gradient-to-br from-emerald-50/80 via-teal-50/50 to-white rounded-3xl border-2 border-emerald-300 p-6 sm:p-8 space-y-6 shadow-md">
        <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 pb-4 border-b border-emerald-200/80">
          <div class="flex items-center gap-3.5">
            <div class="w-11 h-11 rounded-2xl bg-[#0F766E] text-white flex items-center justify-center text-xl font-bold shadow-xs">
              ⚙️
            </div>
            <div>
              <div class="flex items-center gap-2 flex-wrap">
                <span class="text-[10px] font-bold uppercase tracking-wider bg-emerald-700 text-white px-2.5 py-0.5 rounded-full font-mono">KONSOL ADMINISTRATOR</span>
                <span class="text-xs text-emerald-800 font-semibold flex items-center gap-1">
                  <span class="w-2 h-2 rounded-full bg-emerald-500 animate-pulse"></span>
                  Hak Akses: Terbuka & Aktif
                </span>
              </div>
              <h3 class="font-serif font-bold text-gray-900 text-lg sm:text-xl mt-0.5">
                Pusat Pelatihan Model Algoritma & Manajemen Data Transaksi
              </h3>
            </div>
          </div>
          <div class="text-xs text-gray-500 font-mono bg-white px-3 py-1.5 rounded-xl border border-emerald-200">
            Model Aktif: <strong class="text-emerald-800 font-bold">Holt-Winters Multiplicative</strong>
          </div>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
          <!-- Action 1: Re-run Forecast -->
          <div class="bg-white p-6 rounded-2xl border border-emerald-200/80 shadow-xs flex flex-col justify-between space-y-4">
            <div>
              <div class="flex items-center gap-2 text-emerald-900 font-bold text-sm sm:text-base">
                <div class="w-7 h-7 rounded-lg bg-emerald-100 text-emerald-700 flex items-center justify-center text-sm">🔮</div>
                <span>Hitung Ulang Algoritma Prediksi</span>
              </div>
              <p class="text-xs text-gray-600 mt-2 leading-relaxed">
                Sistem akan mengevaluasi ketiga algoritma deret waktu (Holt-Winters Multiplicative, Regresi Musiman, dan Moving Average) pada holdout data 6 bulan terakhir, kemudian memperbarui proyeksi 12 bulan mendatang.
              </p>
            </div>
            <div>
              <button type="button" id="btn-run-forecast" class="w-full text-xs font-bold px-4 py-3 rounded-xl bg-[#0F766E] hover:bg-[#0D6E6E] active:scale-95 text-white transition flex items-center justify-center gap-2 shadow-sm">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"/>
                </svg>
                <span>Jalankan Kalkulasi Prediksi Sekarang</span>
              </button>
              <div id="forecast-status" class="mt-2.5 text-xs font-medium"></div>
            </div>
          </div>

          <!-- Action 2: Import CSV -->
          <div class="bg-white p-6 rounded-2xl border border-emerald-200/80 shadow-xs flex flex-col justify-between space-y-4">
            <div>
              <div class="flex items-center gap-2 text-emerald-900 font-bold text-sm sm:text-base">
                <div class="w-7 h-7 rounded-lg bg-emerald-100 text-emerald-700 flex items-center justify-center text-sm">📁</div>
                <span>Impor Transaksi Baru (.CSV)</span>
              </div>
              <p class="text-xs text-gray-600 mt-2 leading-relaxed">
                Unggah berkas CSV transaksi harian kerajinan eboni untuk memperbarui database analitik. Berkas akan divalidasi terhadap skema database secara otomatis.
              </p>
            </div>
            <form id="import-form" action="<?= $base ?>/api/v1/import/transactions" method="POST" enctype="multipart/form-data" class="space-y-3">
              <input type="hidden" name="csrf_token" value="<?= \App\Core\Csrf::token() ?>">
              <input type="file" name="csv_file" id="csv-file-input" accept=".csv" required class="block w-full text-xs text-gray-500 file:mr-3 file:py-2 file:px-3.5 file:rounded-xl file:border-0 file:text-xs file:font-semibold file:bg-[#0F766E]/10 file:text-[#0F766E] hover:file:bg-[#0F766E]/20 cursor-pointer">
              <button type="submit" id="btn-submit-import" class="w-full text-xs font-semibold px-4 py-2.5 rounded-xl bg-gray-100 hover:bg-gray-200 active:scale-95 text-gray-800 transition flex items-center justify-center gap-2">
                <svg class="w-4 h-4 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12"/>
                </svg>
                <span>Unggah & Validasi CSV</span>
              </button>
              <div id="import-status" class="text-xs font-medium"></div>
            </form>
          </div>
        </div>
      </div>

    <?php else: ?>
      <!-- LOCKED PUBLIC VISITOR PREVIEW -->
      <div class="bg-gradient-to-br from-stone-50 via-[#FAF7F2] to-amber-50/40 rounded-3xl border-2 border-dashed border-[#DED1BF] p-8 text-center space-y-4 shadow-xs">
        <div class="w-14 h-14 rounded-2xl bg-amber-100 text-amber-800 mx-auto flex items-center justify-center text-2xl shadow-xs">
          🔒
        </div>
        <div class="max-w-lg mx-auto space-y-1.5">
          <div class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-[11px] font-bold bg-amber-100 text-amber-800 border border-amber-300">
            <span>FITUR MANAJEMEN MODEL & DATA TERKUNCI</span>
          </div>
          <h4 class="font-serif font-bold text-gray-900 text-lg sm:text-xl">
            Pusat Pelatihan Algoritma Khusus Administrator
          </h4>
          <p class="text-xs text-gray-600 leading-relaxed">
            Seluruh hasil peramalan 12 bulan (C22–C25) dan visualisasi data di atas dapat Anda amati secara bebas. Untuk melatih ulang model deret waktu dengan parameter baru atau mengunggah data transaksi CSV harian, silakan masuk ke Konsol Administrator.
          </p>
        </div>
        <div class="pt-2">
          <a href="<?= $base ?>/login" class="inline-flex items-center gap-2 px-6 py-3 rounded-xl bg-[#0F766E] hover:bg-[#0D6E6E] active:scale-95 text-white text-xs font-semibold shadow-md transition group">
            <svg class="w-4 h-4 text-emerald-200 group-hover:scale-110 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/>
            </svg>
            <span>Masuk sebagai Administrator untuk Membuka Kontrol</span>
          </a>
        </div>
      </div>
    <?php endif; ?>

  </section>

</div>

<!-- ============================================================== -->
<!-- FLOATING ASSISTANT BUTTON (MATCHING IMAGE 1 & 2 "Tanya Wisata") -->
<!-- ============================================================== -->
<button id="btn-floating-assistant" class="fixed bottom-6 right-6 z-40 bg-[#0F766E] hover:bg-[#0D6E6E] text-white px-5 py-3 rounded-full shadow-2xl flex items-center gap-2.5 font-medium text-xs sm:text-sm transition transform hover:scale-105 active:scale-95 border border-white/20">
  <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"/>
  </svg>
  <span>Tanya Analis UMKM</span>
</button>

<!-- Slide-over Assistant Drawer -->
<div id="assistant-drawer" class="fixed inset-0 z-50 bg-black/50 backdrop-blur-xs hidden justify-end">
  <div class="bg-white w-full max-w-md h-full shadow-2xl flex flex-col justify-between animate-in slide-in-from-right duration-200">
    <div class="p-5 border-b border-gray-100 flex items-center justify-between bg-[#0F766E] text-white">
      <div class="flex items-center gap-2.5">
        <span class="w-8 h-8 rounded-full bg-white/20 flex items-center justify-center text-base">💬</span>
        <div>
          <h4 class="font-bold text-sm">Asisten Analis UMKM</h4>
          <p class="text-[11px] text-teal-100">Panduan Cerdas 25 Chart & Prediksi Eboni</p>
        </div>
      </div>
      <button id="btn-close-assistant" class="w-8 h-8 rounded-full bg-white/10 hover:bg-white/25 flex items-center justify-center text-white text-sm font-bold">✕</button>
    </div>

    <div class="p-5 flex-1 overflow-y-auto space-y-4 text-xs text-gray-700 leading-relaxed">
      <div class="bg-teal-50 border border-teal-200 p-3.5 rounded-2xl text-[#0F766E]">
        <strong>Halo!</strong> Saya asisten analis data UMKM Sumber Urip Ebony Palu. Ada yang bisa saya bantu terkait 25 chart atau model prediksi Holt-Winters?
      </div>

      <div class="space-y-2">
        <div class="font-semibold text-gray-500 uppercase text-[10px] tracking-wider">Pertanyaan Cepat:</div>
        <button class="quick-question-btn w-full text-left p-2.5 rounded-xl border border-gray-200 hover:border-[#0F766E] hover:bg-teal-50/50 transition" data-reply="Algoritma Holt-Winters Multiplicative dipilih secara otomatis karena menghasilkan MAPE terendah yaitu 7,42% (kategori Sangat Baik ≤ 10%), mengungguli Regresi Musiman (14,8%) dan SMA (18,6%). Model ini sangat adaptif terhadap siklus lonjakan ganda penjualan khas Sulawesi Tengah.">
          🔮 Mengapa algoritma Holt-Winters yang dipilih?
        </button>
        <button class="quick-question-btn w-full text-left p-2.5 rounded-xl border border-gray-200 hover:border-[#0F766E] hover:bg-teal-50/50 transition" data-reply="Dua puncak tertinggi tahunan terjadi pada bulan Juli (liburan sekolah & wisatawan Palu) serta bulan Desember (pesanan cinderamata akhir tahun & hari raya). Kebutuhan stok harus ditingkatkan sejak 1 bulan sebelumnya.">
          📅 Kapan bulan puncak penjualan kerajinan eboni?
        </button>
        <button class="quick-question-btn w-full text-left p-2.5 rounded-xl border border-gray-200 hover:border-[#0F766E] hover:bg-teal-50/50 transition" data-reply="Uji Pareto 80/20 menunjukkan bahwa hanya 5 dari 18 produk (27,8% SKU) yang menyumbang 79,4% total pendapatan usaha: Patung Kepala Adat, Miniatur Penari Pamonte, Jam Meja Eboni, Kotak Perhiasan, dan Tongkat Komando.">
          🪵 Produk apa saja yang menyumbang 80% omzet?
        </button>
        <button class="quick-question-btn w-full text-left p-2.5 rounded-xl border border-gray-200 hover:border-[#0F766E] hover:bg-teal-50/50 transition" data-reply="Semua 25 chart dapat diakses langsung oleh publik tanpa perlu login. Hak akses login hanya diperlukan untuk Administrator guna melatih ulang model algoritma dan mengimpor file CSV transaksi baru.">
          🔒 Mengapa login hanya untuk admin?
        </button>
      </div>

      <div id="assistant-chat-output" class="space-y-2 pt-2"></div>
    </div>

    <div class="p-4 border-t border-gray-100 bg-gray-50 flex items-center gap-2">
      <input type="text" id="assistant-input" placeholder="Tanyakan seputar data eboni..." class="flex-1 bg-white border border-gray-200 rounded-xl px-3 py-2 text-xs outline-none focus:border-[#0F766E]">
      <button id="btn-assistant-send" class="bg-[#0F766E] text-white px-3.5 py-2 rounded-xl text-xs font-semibold hover:bg-[#0D6E6E] transition">Kirim</button>
    </div>
  </div>
</div>
