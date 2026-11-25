<!-- OPERASIONAL & BIAYA (Halaman 5) -->
<div id="kpi-container" class="kpi-row">
  <!-- Dynamic KPIs loaded by app.js -->
</div>

<div class="grid-12">
  <!-- C19: Stok vs Terjual (12 Kolom) -->
  <div class="chart-card col-12" data-chart-id="c19">
    <div class="chart-header">
      <div class="chart-title-area">
        <h3>Stok Akhir vs Unit Terjual (C19)</h3>
        <p class="chart-subtitle">Apakah persediaan stok selaras dengan permintaan (risiko kelebihan/kekurangan)?</p>
      </div>
      <div class="chart-actions">
        <button class="btn-chart-more">⋮</button>
        <div class="chart-menu">
          <button class="chart-menu-item" data-action="download-png">Unduh PNG</button>
          <a class="chart-menu-item" href="<?= dirname($_SERVER['SCRIPT_NAME'] ?? '') ?>/api/v1/export/c19.csv">Ekspor CSV</a>
          <button class="chart-menu-item" data-action="fullscreen">Layar Penuh</button>
        </div>
      </div>
    </div>
    <div class="chart-body"></div>
    <div class="chart-footer">
      <span>Area: Stok Gudang | Kolom: Unit Terjual</span>
      <span>Tipe: Combo Chart</span>
    </div>
  </div>

  <!-- C20: Struktur Biaya per Tahun (6 Kolom) -->
  <div class="chart-card col-6" data-chart-id="c20">
    <div class="chart-header">
      <div class="chart-title-area">
        <h3>Struktur Biaya Usaha per Tahun (C20)</h3>
        <p class="chart-subtitle">Komponen biaya mana yang paling besar dan bagaimana pergeserannya?</p>
      </div>
      <div class="chart-actions">
        <button class="btn-chart-more">⋮</button>
        <div class="chart-menu">
          <button class="chart-menu-item" data-action="download-png">Unduh PNG</button>
          <a class="chart-menu-item" href="<?= dirname($_SERVER['SCRIPT_NAME'] ?? '') ?>/api/v1/export/c20.csv">Ekspor CSV</a>
          <button class="chart-menu-item" data-action="fullscreen">Layar Penuh</button>
        </div>
      </div>
    </div>
    <div class="chart-body"></div>
    <div class="chart-footer">
      <span>Biaya Bahan Baku, Upah, Operasional</span>
      <span>Tipe: 100% Stacked Horizontal Bar</span>
    </div>
  </div>

  <!-- C21: Boxplot Lead Time Produksi (6 Kolom) -->
  <div class="chart-card col-6" data-chart-id="c21">
    <div class="chart-header">
      <div class="chart-title-area">
        <h3>Lead Time Produksi per Kategori (C21)</h3>
        <p class="chart-subtitle">Berapa lama waktu pembuatan dan seberapa bervariasi untuk janji pengiriman?</p>
      </div>
      <div class="chart-actions">
        <button class="btn-chart-more">⋮</button>
        <div class="chart-menu">
          <button class="chart-menu-item" data-action="download-png">Unduh PNG</button>
          <a class="chart-menu-item" href="<?= dirname($_SERVER['SCRIPT_NAME'] ?? '') ?>/api/v1/export/c21.csv">Ekspor CSV</a>
          <button class="chart-menu-item" data-action="fullscreen">Layar Penuh</button>
        </div>
      </div>
    </div>
    <div class="chart-body"></div>
    <div class="chart-footer">
      <span>Min, Q1, Median, Q3, Maksimum (Hari)</span>
      <span>Tipe: Boxplot</span>
    </div>
  </div>

  <!-- Insight Panel (12 Kolom) -->
  <div class="col-12">
    <div class="insight-panel">
      <div class="insight-header">
        <svg width="22" height="22" fill="var(--amber)" viewBox="0 0 24 24">
          <path d="M12 2a7 7 0 00-7 7c0 2.38 1.19 4.47 3 5.74V17a1 1 0 001 1h6a1 1 0 001-1v-2.26c1.81-1.27 3-3.36 3-5.74a7 7 0 00-7-7zM9 21a1 1 0 001 1h4a1 1 0 001-1v-1H9v1z"/>
        </svg>
        <h3>Insight Efisiensi & Produksi</h3>
      </div>
      <div id="insight-list" class="insight-list"></div>
    </div>
  </div>
</div>
