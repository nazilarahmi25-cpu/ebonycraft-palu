<!-- CHANNEL & WILAYAH (Halaman 3) -->
<div id="kpi-container" class="kpi-row">
  <!-- Dynamic KPIs loaded by app.js -->
</div>

<div class="grid-12">
  <!-- C11: Pendapatan per Channel (6 Kolom) -->
  <div class="chart-card col-6" data-chart-id="c11">
    <div class="chart-header">
      <div class="chart-title-area">
        <h3>Pendapatan per Channel (C11)</h3>
        <p class="chart-subtitle">Channel mana yang paling produktif menghasilkan omzet?</p>
      </div>
      <div class="chart-actions">
        <button class="btn-chart-more">⋮</button>
        <div class="chart-menu">
          <button class="chart-menu-item" data-action="download-png">Unduh PNG</button>
          <a class="chart-menu-item" href="<?= dirname($_SERVER['SCRIPT_NAME'] ?? '') ?>/api/v1/export/c11.csv">Ekspor CSV</a>
          <button class="chart-menu-item" data-action="fullscreen">Layar Penuh</button>
        </div>
      </div>
    </div>
    <div class="chart-body"></div>
    <div class="chart-footer">
      <span>6 Kanal Pemasaran Aktif</span>
      <span>Tipe: Column Bar</span>
    </div>
  </div>

  <!-- C12: Pergeseran Porsi Channel (6 Kolom) -->
  <div class="chart-card col-6" data-chart-id="c12">
    <div class="chart-header">
      <div class="chart-title-area">
        <h3>Pergeseran Porsi Channel per Tahun (C12)</h3>
        <p class="chart-subtitle">Apakah penjualan bergeser dari toko offline ke kanal digital?</p>
      </div>
      <div class="chart-actions">
        <button class="btn-chart-more">⋮</button>
        <div class="chart-menu">
          <button class="chart-menu-item" data-action="download-png">Unduh PNG</button>
          <a class="chart-menu-item" href="<?= dirname($_SERVER['SCRIPT_NAME'] ?? '') ?>/api/v1/export/c12.csv">Ekspor CSV</a>
          <button class="chart-menu-item" data-action="fullscreen">Layar Penuh</button>
        </div>
      </div>
    </div>
    <div class="chart-body"></div>
    <div class="chart-footer">
      <span>Transformasi Digital 2023 - 2026</span>
      <span>Tipe: 100% Stacked Column</span>
    </div>
  </div>

  <!-- C13: Treemap Wilayah (8 Kolom) -->
  <div class="chart-card col-8" data-chart-id="c13">
    <div class="chart-header">
      <div class="chart-title-area">
        <h3>Pendapatan per Wilayah (C13)</h3>
        <p class="chart-subtitle">Dari mana pembeli berasal (Palu, kabupaten Sulteng, atau luar daerah)?</p>
      </div>
      <div class="chart-actions">
        <button class="btn-chart-more">⋮</button>
        <div class="chart-menu">
          <button class="chart-menu-item" data-action="download-png">Unduh PNG</button>
          <a class="chart-menu-item" href="<?= dirname($_SERVER['SCRIPT_NAME'] ?? '') ?>/api/v1/export/c13.csv">Ekspor CSV</a>
          <button class="chart-menu-item" data-action="fullscreen">Layar Penuh</button>
        </div>
      </div>
    </div>
    <div class="chart-body"></div>
    <div class="chart-footer">
      <span>Wilayah Sulteng, Domestik & Luar Negeri</span>
      <span>Tipe: Treemap</span>
    </div>
  </div>

  <!-- C14: Segmen Pembeli (4 Kolom) -->
  <div class="chart-card col-4" data-chart-id="c14">
    <div class="chart-header">
      <div class="chart-title-area">
        <h3>Segmen Pembeli (C14)</h3>
        <p class="chart-subtitle">Siapa target utama: wisatawan, lokal, instansi, atau reseller?</p>
      </div>
      <div class="chart-actions">
        <button class="btn-chart-more">⋮</button>
        <div class="chart-menu">
          <button class="chart-menu-item" data-action="download-png">Unduh PNG</button>
          <a class="chart-menu-item" href="<?= dirname($_SERVER['SCRIPT_NAME'] ?? '') ?>/api/v1/export/c14.csv">Ekspor CSV</a>
          <button class="chart-menu-item" data-action="fullscreen">Layar Penuh</button>
        </div>
      </div>
    </div>
    <div class="chart-body"></div>
    <div class="chart-footer">
      <span>5 Profil Pembeli</span>
      <span>Tipe: Pie Chart</span>
    </div>
  </div>

  <!-- Insight Panel (12 Kolom) -->
  <div class="col-12">
    <div class="insight-panel">
      <div class="insight-header">
        <svg width="22" height="22" fill="var(--amber)" viewBox="0 0 24 24">
          <path d="M12 2a7 7 0 00-7 7c0 2.38 1.19 4.47 3 5.74V17a1 1 0 001 1h6a1 1 0 001-1v-2.26c1.81-1.27 3-3.36 3-5.74a7 7 0 00-7-7zM9 21a1 1 0 001 1h4a1 1 0 001-1v-1H9v1z"/>
        </svg>
        <h3>Insight Distribusi & Saluran Penjualan</h3>
      </div>
      <div id="insight-list" class="insight-list"></div>
    </div>
  </div>
</div>
