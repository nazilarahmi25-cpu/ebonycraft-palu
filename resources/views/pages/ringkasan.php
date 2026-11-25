<!-- RINGKASAN PENJUALAN (Halaman 1) -->
<div id="kpi-container" class="kpi-row">
  <!-- Dynamic KPIs loaded by app.js -->
</div>

<div class="grid-12">
  <!-- C01: Tren Pendapatan Bulanan (8 Kolom) -->
  <div class="chart-card col-8" data-chart-id="c01">
    <div class="chart-header">
      <div class="chart-title-area">
        <h3>Tren Pendapatan Bulanan (C01)</h3>
        <p class="chart-subtitle">Bagaimana arah pendapatan dari waktu ke waktu?</p>
      </div>
      <div class="chart-actions">
        <button class="btn-chart-more" title="Opsi Chart">⋮</button>
        <div class="chart-menu">
          <button class="chart-menu-item" data-action="download-png">Unduh PNG</button>
          <a class="chart-menu-item" href="<?= dirname($_SERVER['SCRIPT_NAME'] ?? '') ?>/api/v1/export/c01.csv">Ekspor CSV</a>
          <button class="chart-menu-item" data-action="fullscreen">Layar Penuh</button>
        </div>
      </div>
    </div>
    <div class="chart-body"></div>
    <div class="chart-footer">
      <span>Sumber: Transaksi Penjualan Bersih</span>
      <span>Tipe: Area Chart</span>
    </div>
  </div>

  <!-- C03: Pendapatan vs Laba Kotor (4 Kolom) -->
  <div class="chart-card col-4" data-chart-id="c03">
    <div class="chart-header">
      <div class="chart-title-area">
        <h3>Pendapatan vs Laba Kotor (C03)</h3>
        <p class="chart-subtitle">Seberapa sehat margin usaha?</p>
      </div>
      <div class="chart-actions">
        <button class="btn-chart-more">⋮</button>
        <div class="chart-menu">
          <button class="chart-menu-item" data-action="download-png">Unduh PNG</button>
          <a class="chart-menu-item" href="<?= dirname($_SERVER['SCRIPT_NAME'] ?? '') ?>/api/v1/export/c03.csv">Ekspor CSV</a>
          <button class="chart-menu-item" data-action="fullscreen">Layar Penuh</button>
        </div>
      </div>
    </div>
    <div class="chart-body"></div>
    <div class="chart-footer">
      <span>Sumber: Analisis HPP Produk</span>
      <span>Tipe: Mixed (Bar + Line)</span>
    </div>
  </div>

  <!-- C02: Perbandingan Tahunan per Bulan (6 Kolom) -->
  <div class="chart-card col-6" data-chart-id="c02">
    <div class="chart-header">
      <div class="chart-title-area">
        <h3>Perbandingan Tahunan per Bulan (C02)</h3>
        <p class="chart-subtitle">Bulan apa yang naik/turun dibanding tahun sebelumnya (YoY)?</p>
      </div>
      <div class="chart-actions">
        <button class="btn-chart-more">⋮</button>
        <div class="chart-menu">
          <button class="chart-menu-item" data-action="download-png">Unduh PNG</button>
          <a class="chart-menu-item" href="<?= dirname($_SERVER['SCRIPT_NAME'] ?? '') ?>/api/v1/export/c02.csv">Ekspor CSV</a>
          <button class="chart-menu-item" data-action="fullscreen">Layar Penuh</button>
        </div>
      </div>
    </div>
    <div class="chart-body"></div>
    <div class="chart-footer">
      <span>Sumber: Perbandingan YoY</span>
      <span>Tipe: Grouped Bar</span>
    </div>
  </div>

  <!-- C04: Heatmap Musiman (6 Kolom) -->
  <div class="chart-card col-6" data-chart-id="c04">
    <div class="chart-header">
      <div class="chart-title-area">
        <h3>Heatmap Musiman Bulan × Tahun (C04)</h3>
        <p class="chart-subtitle">Kapan musim ramai dan sepi secara konsisten?</p>
      </div>
      <div class="chart-actions">
        <button class="btn-chart-more">⋮</button>
        <div class="chart-menu">
          <button class="chart-menu-item" data-action="download-png">Unduh PNG</button>
          <a class="chart-menu-item" href="<?= dirname($_SERVER['SCRIPT_NAME'] ?? '') ?>/api/v1/export/c04.csv">Ekspor CSV</a>
          <button class="chart-menu-item" data-action="fullscreen">Layar Penuh</button>
        </div>
      </div>
    </div>
    <div class="chart-body"></div>
    <div class="chart-footer">
      <span>Sumber: Matriks Pendapatan (Juta Rp)</span>
      <span>Tipe: Heatmap</span>
    </div>
  </div>

  <!-- C05: Penjualan per Hari dalam Seminggu (6 Kolom) -->
  <div class="chart-card col-6" data-chart-id="c05">
    <div class="chart-header">
      <div class="chart-title-area">
        <h3>Penjualan per Hari dalam Seminggu (C05)</h3>
        <p class="chart-subtitle">Hari apa pembeli paling banyak untuk jadwal promosi/jaga toko?</p>
      </div>
      <div class="chart-actions">
        <button class="btn-chart-more">⋮</button>
        <div class="chart-menu">
          <button class="chart-menu-item" data-action="download-png">Unduh PNG</button>
          <a class="chart-menu-item" href="<?= dirname($_SERVER['SCRIPT_NAME'] ?? '') ?>/api/v1/export/c05.csv">Ekspor CSV</a>
          <button class="chart-menu-item" data-action="fullscreen">Layar Penuh</button>
        </div>
      </div>
    </div>
    <div class="chart-body"></div>
    <div class="chart-footer">
      <span>Sumber: Pola Harian Transaksi</span>
      <span>Tipe: Column Bar</span>
    </div>
  </div>

  <!-- Insight Otomatis (6 Kolom) -->
  <div class="col-6">
    <div class="insight-panel">
      <div class="insight-header">
        <svg width="22" height="22" fill="var(--amber)" viewBox="0 0 24 24">
          <path d="M12 2a7 7 0 00-7 7c0 2.38 1.19 4.47 3 5.74V17a1 1 0 001 1h6a1 1 0 001-1v-2.26c1.81-1.27 3-3.36 3-5.74a7 7 0 00-7-7zM9 21a1 1 0 001 1h4a1 1 0 001-1v-1H9v1z"/>
        </svg>
        <h3>Insight Otomatis Bisnis</h3>
      </div>
      <div id="insight-list" class="insight-list">
        <!-- Loaded dynamically -->
      </div>
    </div>
  </div>
</div>
