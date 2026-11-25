<?php
$isAdmin = $is_admin ?? false;
$base = dirname($_SERVER['SCRIPT_NAME'] ?? '');
if ($base === '/' || $base === '\\') $base = '';
?>
<!DOCTYPE html>
<html lang="id" class="scroll-smooth">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title><?= htmlspecialchars($title ?? 'EbonyCraft Palu — Analisis & Prediksi Kerajinan Eboni Sulteng') ?></title>
  
  <!-- Tailwind CSS CDN -->
  <script src="https://cdn.tailwindcss.com"></script>
  <script>
    tailwind.config = {
      darkMode: 'class',
      theme: {
        extend: {
          colors: {
            sulteng: {
              50: '#F0F9F9',
              100: '#E0F2F1',
              200: '#B2DFDB',
              500: '#0F766E',
              600: '#0D6E6E',
              700: '#0B5E5E',
              800: '#094E4E',
              900: '#063A3A',
            },
            coral: {
              50: '#FDF2F0',
              500: '#E76F51',
              600: '#D85A3C',
              700: '#C24B2F',
            },
            cream: {
              50: '#FAF7F2',
              100: '#F5EFE6',
              200: '#EBE2D5',
              300: '#DED1BF',
            },
            ebony: {
              700: '#3B2A20',
              800: '#2A211B',
              900: '#1C1410',
            }
          },
          fontFamily: {
            sans: ['Inter', 'system-ui', '-apple-system', 'sans-serif'],
            serif: ['Playfair Display', 'Georgia', 'serif'],
          }
        }
      }
    }
  </script>

  <!-- Google Fonts: Inter & Playfair Display -->
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&family=Playfair+Display:ital,wght@0,600;0,700;1,600&display=swap" rel="stylesheet">

  <style>
    /* Custom Scrollbar */
    ::-webkit-scrollbar { width: 8px; height: 8px; }
    ::-webkit-scrollbar-track { background: #FAF7F2; }
    ::-webkit-scrollbar-thumb { background: #DED1BF; border-radius: 9999px; }
    ::-webkit-scrollbar-thumb:hover { background: #0F766E; }
  </style>
</head>
<body class="bg-[#FAF7F2] text-[#2A211B] font-sans antialiased min-h-screen flex flex-col" data-page="<?= htmlspecialchars($active_page ?? 'dashboard') ?>">

  <?php if ($isAdmin): ?>
    <!-- ============================================================== -->
    <!-- TAMPILAN KHUSUS ADMIN: STANDAR DASHBOARD (SIDEBAR KIRI + KONTEN) -->
    <!-- ============================================================== -->
    <div class="flex min-h-screen w-full bg-[#FAF7F2] items-start">
      <!-- Left Sidebar Admin -->
      <?php include __DIR__ . '/partials/sidebar.php'; ?>

      <!-- Right Column: Topbar Admin + Konten Dashboard -->
      <div class="flex-1 flex flex-col min-w-0 min-h-screen">
        <!-- Topbar Admin -->
        <?php include __DIR__ . '/partials/topbar_admin.php'; ?>

        <!-- Main Content Slot -->
        <main class="flex-1 w-full">
          <?= $content ?? '' ?>
        </main>

        <!-- Footer Admin -->
        <footer class="bg-white border-t border-[#EBE2D5] py-4 px-6 text-xs text-gray-500 flex flex-col sm:flex-row items-center justify-between gap-2 mt-8">
          <div class="flex items-center gap-2">
            <span class="w-5 h-5 rounded-md bg-[#0F766E] text-white flex items-center justify-center font-serif font-bold text-xs">E</span>
            <span>© <?= date('Y') ?> EbonyCraft Palu • Panel Administrator UMKM Sumber Urip</span>
          </div>
          <span class="text-emerald-700 font-medium flex items-center gap-1.5">
            <span class="w-2 h-2 rounded-full bg-emerald-500 animate-pulse"></span>
            Mode Administrator Aktif (Hak Akses Penuh)
          </span>
        </footer>
      </div>
    </div>

  <?php else: ?>
    <!-- ============================================================== -->
    <!-- TAMPILAN UMUM / PUBLIK: PORTAL ATAS (HORIZONTAL NAV TANPA SIDEBAR) -->
    <!-- ============================================================== -->
    <!-- Top Navigation Bar (Header dengan tombol navigasi di atas) -->
    <?php include __DIR__ . '/partials/topbar.php'; ?>

    <!-- Main Content Slot -->
    <main class="flex-1 w-full">
      <?= $content ?? '' ?>
    </main>

    <!-- Footer Publik -->
    <footer class="bg-[#1C1410] text-[#D6C7B2] border-t border-[#3B2A20] mt-16 py-8 px-4 sm:px-6 lg:px-8">
      <div class="max-w-7xl mx-auto flex flex-col md:flex-row items-center justify-between gap-4 text-center md:text-left text-xs">
        <div>
          <div class="flex items-center justify-center md:justify-start gap-2.5">
            <span class="w-6 h-6 rounded-lg bg-[#0F766E] text-white flex items-center justify-center font-serif font-bold text-sm">E</span>
            <span class="font-bold text-sm text-white">EbonyCraft Palu</span>
          </div>
          <p class="text-[#A89F91] mt-1 max-w-md text-[11px] leading-relaxed">
            Sistem Analisis & Prediksi Penjualan UMKM Sumber Urip Ebony • Kota Palu, Sulawesi Tengah.
          </p>
        </div>
        <div class="text-[11px] text-gray-400 space-y-0.5">
          <div>25 Visualisasi Chart Terkurasi • Tersedia Akses Publik</div>
          <div class="text-[10px] text-gray-500">© <?= date('Y') ?> EbonyCraft Palu. Seluruh hak cipta dilindungi.</div>
        </div>
      </div>
    </footer>
  <?php endif; ?>

  <!-- Modal View Data Tabel (Popup saat tombol [Tabel] diklik) -->
  <div id="table-modal" class="fixed inset-0 bg-black/60 backdrop-blur-sm z-50 hidden flex items-center justify-center p-4">
    <div class="bg-white rounded-2xl max-w-3xl w-full max-h-[85vh] flex flex-col shadow-2xl border border-gray-200 overflow-hidden animate-in fade-in zoom-in duration-200">
      <div class="px-6 py-4 border-b border-gray-100 flex items-center justify-between bg-gray-50">
        <div>
          <h4 id="table-modal-title" class="font-bold text-gray-900 text-base">Detail Tabel Data</h4>
          <p id="table-modal-sub" class="text-xs text-gray-500">Rincian angka metrik penjualan</p>
        </div>
        <button id="btn-close-table-modal" class="w-8 h-8 rounded-full bg-gray-200 hover:bg-gray-300 text-gray-700 flex items-center justify-center text-sm font-bold">✕</button>
      </div>
      <div class="p-6 overflow-y-auto flex-1">
        <div class="overflow-x-auto">
          <table class="w-full text-left text-xs border-collapse">
            <thead id="table-modal-thead" class="bg-[#0F766E] text-white uppercase text-[11px] font-semibold sticky top-0"></thead>
            <tbody id="table-modal-tbody" class="divide-y divide-gray-100"></tbody>
          </table>
        </div>
      </div>
      <div class="px-6 py-3 border-t border-gray-100 bg-gray-50 flex items-center justify-between text-xs text-gray-500">
        <span>Format Angka: Rupiah (IDR) & Persen (%)</span>
        <button id="btn-modal-close-footer" class="px-4 py-1.5 bg-gray-200 hover:bg-gray-300 rounded-lg text-gray-800 font-medium">Tutup</button>
      </div>
    </div>
  </div>

  <!-- ApexCharts Library -->
  <script src="<?= dirname($_SERVER['SCRIPT_NAME'] ?? '') ?>/assets/vendor/apexcharts.min.js"></script>
  <script>
    if (typeof ApexCharts === 'undefined') {
      document.write('<script src="https://cdn.jsdelivr.net/npm/apexcharts"><\/script>');
    }
  </script>

  <!-- ES Module Application -->
  <script type="module" src="<?= dirname($_SERVER['SCRIPT_NAME'] ?? '') ?>/assets/js/app.js"></script>
</body>
</html>
