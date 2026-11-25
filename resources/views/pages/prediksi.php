<!-- PREDIKSI PENJUALAN (Halaman 6) -->
<div id="kpi-container" class="kpi-row">
  <!-- Dynamic KPIs loaded by app.js -->
</div>

<div class="grid-12">
  <!-- C22: Prediksi Pendapatan 12 Bulan + Interval 95% (12 Kolom) -->
  <div class="chart-card col-12" data-chart-id="c22">
    <div class="chart-header">
      <div class="chart-title-area">
        <h3>Prediksi Pendapatan 12 Bulan Mendatang (C22)</h3>
        <p class="chart-subtitle">Berapa pendapatan bulan-bulan mendatang dan rentang keyakinan 95%?</p>
      </div>
      <div class="chart-actions">
        <button class="btn-chart-more">⋮</button>
        <div class="chart-menu">
          <button class="chart-menu-item" data-action="download-png">Unduh PNG</button>
          <a class="chart-menu-item" href="<?= dirname($_SERVER['SCRIPT_NAME'] ?? '') ?>/api/v1/export/c22.csv">Ekspor CSV</a>
          <button class="chart-menu-item" data-action="fullscreen">Layar Penuh</button>
        </div>
      </div>
    </div>
    <div class="chart-body"></div>
    <div class="chart-footer">
      <span>Garis Putus: Prediksi | Bidang Transparan: Interval Keyakinan 95%</span>
      <span>Tipe: Line + Range Area</span>
    </div>
  </div>

  <!-- C23: Uji Mundur Aktual vs 3 Model (8 Kolom) -->
  <div class="chart-card col-8" data-chart-id="c23">
    <div class="chart-header">
      <div class="chart-title-area">
        <h3>Uji Mundur (Backtest): Aktual vs 3 Model (C23)</h3>
        <p class="chart-subtitle">Model mana yang paling akurat mengikuti pola data historis pengujian?</p>
      </div>
      <div class="chart-actions">
        <button class="btn-chart-more">⋮</button>
        <div class="chart-menu">
          <button class="chart-menu-item" data-action="download-png">Unduh PNG</button>
          <a class="chart-menu-item" href="<?= dirname($_SERVER['SCRIPT_NAME'] ?? '') ?>/api/v1/export/c23.csv">Ekspor CSV</a>
          <button class="chart-menu-item" data-action="fullscreen">Layar Penuh</button>
        </div>
      </div>
    </div>
    <div class="chart-body"></div>
    <div class="chart-footer">
      <span>Evaluasi Holdout 12 Bulan (Nov 2025 - Okt 2026)</span>
      <span>Tipe: Multi-line Chart</span>
    </div>
  </div>

  <!-- C24: Akurasi Model MAPE & NRMSE (4 Kolom) -->
  <div class="chart-card col-4" data-chart-id="c24">
    <div class="chart-header">
      <div class="chart-title-area">
        <h3>Perbandingan Akurasi Model (C24)</h3>
        <p class="chart-subtitle">Model mana paling akurat berdasarkan error terendah?</p>
      </div>
      <div class="chart-actions">
        <button class="btn-chart-more">⋮</button>
        <div class="chart-menu">
          <button class="chart-menu-item" data-action="download-png">Unduh PNG</button>
          <a class="chart-menu-item" href="<?= dirname($_SERVER['SCRIPT_NAME'] ?? '') ?>/api/v1/export/c24.csv">Ekspor CSV</a>
          <button class="chart-menu-item" data-action="fullscreen">Layar Penuh</button>
        </div>
      </div>
    </div>
    <div class="chart-body"></div>
    <div class="chart-footer">
      <span>Metrik: MAPE & NRMSE (%)</span>
      <span>Tipe: Grouped Bar</span>
    </div>
  </div>

  <!-- C25: Prediksi per Kategori Produk (12 Kolom) -->
  <div class="chart-card col-12" data-chart-id="c25">
    <div class="chart-header">
      <div class="chart-title-area">
        <h3>Prediksi Penjualan per Kategori Produk (C25)</h3>
        <p class="chart-subtitle">Kategori mana yang perlu dipersiapkan stok & produksinya?</p>
      </div>
      <div class="chart-actions">
        <button class="btn-chart-more">⋮</button>
        <div class="chart-menu">
          <button class="chart-menu-item" data-action="download-png">Unduh PNG</button>
          <a class="chart-menu-item" href="<?= dirname($_SERVER['SCRIPT_NAME'] ?? '') ?>/api/v1/export/c25.csv">Ekspor CSV</a>
          <button class="chart-menu-item" data-action="fullscreen">Layar Penuh</button>
        </div>
      </div>
    </div>
    <div class="chart-body"></div>
    <div class="chart-footer">
      <span>Proyeksi Rekonsiliasi Top-Down Proporsional</span>
      <span>Tipe: Stacked Column</span>
    </div>
  </div>

  <!-- Tabel Rekomendasi Stok & Produksi (12 Kolom) -->
  <div class="col-12">
    <div class="chart-card" style="padding: 24px;">
      <h3 style="font-size: 16px; font-weight: 600; color: var(--ebony-900); margin-bottom: 4px;">
        Rekomendasi Jadwal Produksi & Pengadaan Bahan Baku (12 Bulan ke Depan)
      </h3>
      <p style="font-size: 13px; color: var(--muted); margin-bottom: 16px;">
        Dihitung dari hasil proyeksi penjualan kategori, harga rata-rata, dan lead time pengerjaan (+10% safety stock).
      </p>

      <div class="data-table-container">
        <table class="data-table">
          <thead>
            <tr>
              <th>Kategori Kerajinan</th>
              <th>Lead Time Rata-rata</th>
              <th>Bulan Puncak Prediksi</th>
              <th>Target Puncak (+10%)</th>
              <th>Total Kebutuhan 1 Tahun</th>
              <th>Jadwal Mulai Produksi</th>
              <th>Rekomendasi Tindakan</th>
            </tr>
          </thead>
          <tbody id="recommendation-tbody">
            <tr>
              <td><strong>Aksesoris</strong></td>
              <td>5 hari</td>
              <td>Desember 2026</td>
              <td>± 320 unit</td>
              <td>± 2.450 unit</td>
              <td>Pertengahan Nov</td>
              <td>Tingkatkan stok gelang polos dan ukir 2 minggu sebelum musim liburan.</td>
            </tr>
            <tr>
              <td><strong>Dekorasi & Patung</strong></td>
              <td>16 hari</td>
              <td>Desember 2026</td>
              <td>± 65 unit</td>
              <td>± 480 unit</td>
              <td>Awal November</td>
              <td>Wajib siapkan balok kayu eboni kering sejak Oktober untuk ukiran patung besar.</td>
            </tr>
            <tr>
              <td><strong>Souvenir</strong></td>
              <td>4 hari</td>
              <td>Juli 2027</td>
              <td>± 680 unit</td>
              <td>± 4.900 unit</td>
              <td>Pertengahan Juni</td>
              <td>Persiapkan gantungan kunci & magnet untuk lonjakan kunjungan wisatawan sekolah.</td>
            </tr>
            <tr>
              <td><strong>Alat Tulis & Fungsional</strong></td>
              <td>7 hari</td>
              <td>September 2027</td>
              <td>± 110 unit</td>
              <td>± 890 unit</td>
              <td>Akhir Agustus</td>
              <td>Persiapkan kotak perhiasan dan pulpen eboni menjelang event HUT & pameran daerah.</td>
            </tr>
            <tr>
              <td><strong>Religi & Seremonial</strong></td>
              <td>9 hari</td>
              <td>Maret 2027</td>
              <td>± 140 unit</td>
              <td>± 950 unit</td>
              <td>Februari 2027</td>
              <td>Tingkatkan produksi tasbih dan rehal 3 minggu sebelum awal bulan suci Ramadan.</td>
            </tr>
          </tbody>
        </table>
      </div>
    </div>
  </div>

  <!-- Panel Admin Kontrol Prediksi & Impor CSV -->
  <?php if ($is_admin ?? false): ?>
  <div class="col-12">
    <div class="chart-card" style="padding: 24px; border: 2px dashed var(--amber);">
      <h3 style="font-size: 16px; font-weight: 600; color: var(--ebony-900); margin-bottom: 8px;">
        Panel Admin — Kontrol Prediksi & Impor Data
      </h3>
      <p style="font-size: 13px; color: var(--muted); margin-bottom: 20px;">
        Fitur khusus admin untuk melatih ulang model algoritma prediksi atau mengimpor data transaksi nyata (CSV).
      </p>

      <div style="display: flex; flex-wrap: wrap; gap: 24px;">
        <!-- Run Forecast Button -->
        <div style="flex: 1; min-width: 280px;">
          <h4 style="font-size: 14px; font-weight: 600; margin-bottom: 8px;">Hitung Ulang Algoritma Prediksi</h4>
          <p style="font-size: 12px; color: var(--muted); margin-bottom: 12px;">
            Sistem akan melatih 3 model (Holt-Winters, Regresi, SMA), mengevaluasi data uji 12 bulan, dan memilih model terbaik otomatis.
          </p>
          <button id="btn-run-forecast" class="btn-primary">
            <svg width="16" height="16" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"/>
            </svg>
            Jalankan Ulang Prediksi Sekarang
          </button>
          <div id="forecast-status" style="margin-top: 8px; font-size: 12px;"></div>
        </div>

        <!-- CSV Import Form -->
        <div style="flex: 1; min-width: 280px; border-left: 1px solid #E8D8BD; padding-left: 24px;">
          <h4 style="font-size: 14px; font-weight: 600; margin-bottom: 8px;">Impor Transaksi Baru (CSV)</h4>
          <form id="import-form" action="<?= dirname($_SERVER['SCRIPT_NAME'] ?? '') ?>/api/v1/import/transactions" method="POST" enctype="multipart/form-data">
            <?= \App\Core\Csrf::field() ?>
            <input type="file" name="csv_file" accept=".csv" required style="font-size: 13px; margin-bottom: 10px; display: block;">
            <button type="submit" class="btn-outline">Unggah & Validasi CSV</button>
          </form>
        </div>
      </div>
    </div>
  </div>

  <script>
    document.querySelector('#btn-run-forecast')?.addEventListener('click', async () => {
      const statusEl = document.querySelector('#forecast-status');
      statusEl.textContent = 'Menghitung prediksi... Mohon tunggu...';
      statusEl.style.color = 'var(--amber)';

      try {
        const res = await fetch('<?= dirname($_SERVER['SCRIPT_NAME'] ?? '') ?>/api/v1/forecast/run', {
          method: 'POST',
          headers: { 'Content-Type': 'application/json' },
          body: JSON.stringify({ csrf_token: '<?= \App\Core\Csrf::token() ?>' })
        });
        const data = await res.json();
        if (res.ok) {
          statusEl.textContent = `✓ Sukses! Model ${data.selected_model} terpilih (MAPE: ${data.mape}%). Memuat ulang halaman...`;
          statusEl.style.color = 'var(--success)';
          setTimeout(() => window.location.reload(), 1500);
        } else {
          statusEl.textContent = 'Gagal: ' + (data.error?.message || 'Error');
          statusEl.style.color = 'var(--danger)';
        }
      } catch (e) {
        statusEl.textContent = 'Gagal menghubungi server.';
        statusEl.style.color = 'var(--danger)';
      }
    });
  </script>
  <?php endif; ?>

  <!-- Insight Panel (12 Kolom) -->
  <div class="col-12">
    <div class="insight-panel">
      <div class="insight-header">
        <svg width="22" height="22" fill="var(--amber)" viewBox="0 0 24 24">
          <path d="M12 2a7 7 0 00-7 7c0 2.38 1.19 4.47 3 5.74V17a1 1 0 001 1h6a1 1 0 001-1v-2.26c1.81-1.27 3-3.36 3-5.74a7 7 0 00-7-7zM9 21a1 1 0 001 1h4a1 1 0 001-1v-1H9v1z"/>
        </svg>
        <h3>Insight Analisis Prediksi</h3>
      </div>
      <div id="insight-list" class="insight-list"></div>
    </div>
  </div>
</div>
