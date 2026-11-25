<!-- ANALISIS PRODUK (Halaman 2) -->
<div id="kpi-container" class="kpi-row">
  <!-- Dynamic KPIs loaded by app.js -->
</div>

<div class="grid-12">
  <!-- C06: Top 10 Produk Terlaris (6 Kolom) -->
  <div class="chart-card col-6" data-chart-id="c06">
    <div class="chart-header">
      <div class="chart-title-area">
        <h3>Top 10 Produk Terlaris (C06)</h3>
        <p class="chart-subtitle">Produk mana penyumbang pendapatan terbesar?</p>
      </div>
      <div class="chart-actions">
        <button class="btn-chart-more">⋮</button>
        <div class="chart-menu">
          <button class="chart-menu-item" data-action="download-png">Unduh PNG</button>
          <a class="chart-menu-item" href="<?= dirname($_SERVER['SCRIPT_NAME'] ?? '') ?>/api/v1/export/c06.csv">Ekspor CSV</a>
          <button class="chart-menu-item" data-action="fullscreen">Layar Penuh</button>
        </div>
      </div>
    </div>
    <div class="chart-body"></div>
    <div class="chart-footer">
      <span>Peringkat Berdasarkan Omzet</span>
      <span>Tipe: Horizontal Bar</span>
    </div>
  </div>

  <!-- C07: Komposisi per Kategori (6 Kolom) -->
  <div class="chart-card col-6" data-chart-id="c07">
    <div class="chart-header">
      <div class="chart-title-area">
        <h3>Komposisi Pendapatan per Kategori (C07)</h3>
        <p class="chart-subtitle">Kategori mana yang mendominasi penjualan?</p>
      </div>
      <div class="chart-actions">
        <button class="btn-chart-more">⋮</button>
        <div class="chart-menu">
          <button class="chart-menu-item" data-action="download-png">Unduh PNG</button>
          <a class="chart-menu-item" href="<?= dirname($_SERVER['SCRIPT_NAME'] ?? '') ?>/api/v1/export/c07.csv">Ekspor CSV</a>
          <button class="chart-menu-item" data-action="fullscreen">Layar Penuh</button>
        </div>
      </div>
    </div>
    <div class="chart-body"></div>
    <div class="chart-footer">
      <span>5 Kategori Kerajinan Eboni</span>
      <span>Tipe: Donut Chart</span>
    </div>
  </div>

  <!-- C08: Analisis Pareto 80/20 (6 Kolom) -->
  <div class="chart-card col-6" data-chart-id="c08">
    <div class="chart-header">
      <div class="chart-title-area">
        <h3>Analisis Pareto 80/20 (C08)</h3>
        <p class="chart-subtitle">Berapa persen produk yang menghasilkan 80% pendapatan?</p>
      </div>
      <div class="chart-actions">
        <button class="btn-chart-more">⋮</button>
        <div class="chart-menu">
          <button class="chart-menu-item" data-action="download-png">Unduh PNG</button>
          <a class="chart-menu-item" href="<?= dirname($_SERVER['SCRIPT_NAME'] ?? '') ?>/api/v1/export/c08.csv">Ekspor CSV</a>
          <button class="chart-menu-item" data-action="fullscreen">Layar Penuh</button>
        </div>
      </div>
    </div>
    <div class="chart-body"></div>
    <div class="chart-footer">
      <span>Aturan 80/20 Prinsip Pareto</span>
      <span>Tipe: Column + Cumulative Line</span>
    </div>
  </div>

  <!-- C09: Bubble Harga-Volume-Margin (6 Kolom) -->
  <div class="chart-card col-6" data-chart-id="c09">
    <div class="chart-header">
      <div class="chart-title-area">
        <h3>Harga vs Volume vs Margin (C09)</h3>
        <p class="chart-subtitle">Produk mana yang volume dan margin tinggi (bintang) vs rendah (evaluasi)?</p>
      </div>
      <div class="chart-actions">
        <button class="btn-chart-more">⋮</button>
        <div class="chart-menu">
          <button class="chart-menu-item" data-action="download-png">Unduh PNG</button>
          <a class="chart-menu-item" href="<?= dirname($_SERVER['SCRIPT_NAME'] ?? '') ?>/api/v1/export/c09.csv">Ekspor CSV</a>
          <button class="chart-menu-item" data-action="fullscreen">Layar Penuh</button>
        </div>
      </div>
    </div>
    <div class="chart-body"></div>
    <div class="chart-footer">
      <span>X: Harga, Y: Volume, Ukuran: Margin %</span>
      <span>Tipe: Bubble Chart</span>
    </div>
  </div>

  <!-- C10: Tren Pendapatan per Kategori (12 Kolom) -->
  <div class="chart-card col-12" data-chart-id="c10">
    <div class="chart-header">
      <div class="chart-title-area">
        <h3>Tren Pendapatan per Kategori (C10)</h3>
        <p class="chart-subtitle">Kategori mana yang tumbuh atau menurun dari waktu ke waktu?</p>
      </div>
      <div class="chart-actions">
        <button class="btn-chart-more">⋮</button>
        <div class="chart-menu">
          <button class="chart-menu-item" data-action="download-png">Unduh PNG</button>
          <a class="chart-menu-item" href="<?= dirname($_SERVER['SCRIPT_NAME'] ?? '') ?>/api/v1/export/c10.csv">Ekspor CSV</a>
          <button class="chart-menu-item" data-action="fullscreen">Layar Penuh</button>
        </div>
      </div>
    </div>
    <div class="chart-body"></div>
    <div class="chart-footer">
      <span>Dinamika Pertumbuhan Kategori</span>
      <span>Tipe: Stacked Area</span>
    </div>
  </div>

  <!-- Insight Panel (12 Kolom) -->
  <div class="col-12">
    <div class="insight-panel">
      <div class="insight-header">
        <svg width="22" height="22" fill="var(--amber)" viewBox="0 0 24 24">
          <path d="M12 2a7 7 0 00-7 7c0 2.38 1.19 4.47 3 5.74V17a1 1 0 001 1h6a1 1 0 001-1v-2.26c1.81-1.27 3-3.36 3-5.74a7 7 0 00-7-7zM9 21a1 1 0 001 1h4a1 1 0 001-1v-1H9v1z"/>
        </svg>
        <h3>Insight Strategi Produk</h3>
      </div>
      <div id="insight-list" class="insight-list"></div>
    </div>
  </div>
</div>
