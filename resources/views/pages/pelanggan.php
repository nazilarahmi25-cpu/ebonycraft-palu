<!-- PELANGGAN & TRANSAKSI (Halaman 4) -->
<div id="kpi-container" class="kpi-row">
  <!-- Dynamic KPIs loaded by app.js -->
</div>

<div class="grid-12">
  <!-- C15: Pelanggan Baru vs Ulang (8 Kolom) -->
  <div class="chart-card col-8" data-chart-id="c15">
    <div class="chart-header">
      <div class="chart-title-area">
        <h3>Pesanan Pelanggan Baru vs Ulang (C15)</h3>
        <p class="chart-subtitle">Apakah loyalitas dan retensi pelanggan meningkat setiap bulan?</p>
      </div>
      <div class="chart-actions">
        <button class="btn-chart-more">⋮</button>
        <div class="chart-menu">
          <button class="chart-menu-item" data-action="download-png">Unduh PNG</button>
          <a class="chart-menu-item" href="<?= dirname($_SERVER['SCRIPT_NAME'] ?? '') ?>/api/v1/export/c15.csv">Ekspor CSV</a>
          <button class="chart-menu-item" data-action="fullscreen">Layar Penuh</button>
        </div>
      </div>
    </div>
    <div class="chart-body"></div>
    <div class="chart-footer">
      <span>Retensi Pelanggan (Repeat Order)</span>
      <span>Tipe: Stacked Column</span>
    </div>
  </div>

  <!-- C17: Metode Pembayaran (4 Kolom) -->
  <div class="chart-card col-4" data-chart-id="c17">
    <div class="chart-header">
      <div class="chart-title-area">
        <h3>Metode Pembayaran (C17)</h3>
        <p class="chart-subtitle">Metode apa yang paling banyak digunakan konsumen?</p>
      </div>
      <div class="chart-actions">
        <button class="btn-chart-more">⋮</button>
        <div class="chart-menu">
          <button class="chart-menu-item" data-action="download-png">Unduh PNG</button>
          <a class="chart-menu-item" href="<?= dirname($_SERVER['SCRIPT_NAME'] ?? '') ?>/api/v1/export/c17.csv">Ekspor CSV</a>
          <button class="chart-menu-item" data-action="fullscreen">Layar Penuh</button>
        </div>
      </div>
    </div>
    <div class="chart-body"></div>
    <div class="chart-footer">
      <span>Tunai, Transfer, QRIS, Marketplace, COD</span>
      <span>Tipe: Radial Bar</span>
    </div>
  </div>

  <!-- C16: Distribusi Nilai Transaksi (6 Kolom) -->
  <div class="chart-card col-6" data-chart-id="c16">
    <div class="chart-header">
      <div class="chart-title-area">
        <h3>Distribusi Nilai Transaksi (C16)</h3>
        <p class="chart-subtitle">Rentang belanja mana yang paling sering terjadi (untuk strategi bundling)?</p>
      </div>
      <div class="chart-actions">
        <button class="btn-chart-more">⋮</button>
        <div class="chart-menu">
          <button class="chart-menu-item" data-action="download-png">Unduh PNG</button>
          <a class="chart-menu-item" href="<?= dirname($_SERVER['SCRIPT_NAME'] ?? '') ?>/api/v1/export/c16.csv">Ekspor CSV</a>
          <button class="chart-menu-item" data-action="fullscreen">Layar Penuh</button>
        </div>
      </div>
    </div>
    <div class="chart-body"></div>
    <div class="chart-footer">
      <span>Kelas Nilai Belanja (Kelipatan Rp 100 rb)</span>
      <span>Tipe: Histogram Bar</span>
    </div>
  </div>

  <!-- C18: Tren AOV (6 Kolom) -->
  <div class="chart-card col-6" data-chart-id="c18">
    <div class="chart-header">
      <div class="chart-title-area">
        <h3>Tren Rata-rata Nilai Order / AOV (C18)</h3>
        <p class="chart-subtitle">Apakah nilai belanja per transaksi mengalami peningkatan?</p>
      </div>
      <div class="chart-actions">
        <button class="btn-chart-more">⋮</button>
        <div class="chart-menu">
          <button class="chart-menu-item" data-action="download-png">Unduh PNG</button>
          <a class="chart-menu-item" href="<?= dirname($_SERVER['SCRIPT_NAME'] ?? '') ?>/api/v1/export/c18.csv">Ekspor CSV</a>
          <button class="chart-menu-item" data-action="fullscreen">Layar Penuh</button>
        </div>
      </div>
    </div>
    <div class="chart-body"></div>
    <div class="chart-footer">
      <span>Average Order Value Bulanan</span>
      <span>Tipe: Line Chart</span>
    </div>
  </div>

  <!-- Insight Panel (12 Kolom) -->
  <div class="col-12">
    <div class="insight-panel">
      <div class="insight-header">
        <svg width="22" height="22" fill="var(--amber)" viewBox="0 0 24 24">
          <path d="M12 2a7 7 0 00-7 7c0 2.38 1.19 4.47 3 5.74V17a1 1 0 001 1h6a1 1 0 001-1v-2.26c1.81-1.27 3-3.36 3-5.74a7 7 0 00-7-7zM9 21a1 1 0 001 1h4a1 1 0 001-1v-1H9v1z"/>
        </svg>
        <h3>Insight Perilaku Pelanggan</h3>
      </div>
      <div id="insight-list" class="insight-list"></div>
    </div>
  </div>
</div>
