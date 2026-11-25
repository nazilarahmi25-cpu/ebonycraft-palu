<?php
$base = dirname($_SERVER['SCRIPT_NAME'] ?? '');
if ($base === '/' || $base === '\\') $base = '';
$isAdmin = $is_admin ?? false;
?>
<header class="sticky top-0 z-40 bg-white/95 backdrop-blur-md border-b border-[#EBE2D5] shadow-xs">
  <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 flex items-center justify-between h-16 gap-3 lg:gap-4">
    
    <!-- Sisi Kiri: Brand Logo & Title -->
    <div class="flex items-center gap-3 flex-shrink-0">
      <a href="<?= $base ?>/" class="flex items-center gap-2.5 group">
        <div class="w-10 h-10 rounded-xl bg-gradient-to-br from-[#0F766E] to-[#0A4F4A] text-white flex items-center justify-center font-serif font-bold text-xl shadow-xs group-hover:scale-105 transition-transform flex-shrink-0">
          <span>E</span>
        </div>
        <div class="flex flex-col">
          <span class="font-bold text-[#1C1410] text-base sm:text-lg tracking-tight leading-tight group-hover:text-[#0F766E] transition-colors">
            EbonyCraft Palu
          </span>
          <span class="text-[11px] text-[#78716C] leading-none mt-0.5">
            UMKM Sumber Urip • Palu, Sulteng
          </span>
        </div>
      </a>
    </div>

    <!-- Bagian Tengah (Atas): Navigation Buttons -->
    <nav class="flex items-center gap-1.5 sm:gap-2 overflow-x-auto scrollbar-none text-xs py-1">
      
      <!-- 1. Semua -->
      <button type="button" class="top-nav-btn active flex-shrink-0 whitespace-nowrap px-4 py-2 rounded-full font-semibold transition bg-[#0F766E] text-white shadow-xs border border-[#0F766E]" data-target="all">
        Semua
      </button>

      <!-- 2. Ringkasan Kinerja -->
      <button type="button" class="top-nav-btn flex-shrink-0 whitespace-nowrap px-4 py-2 rounded-full font-medium text-gray-700 hover:text-[#0F766E] hover:bg-[#FAF7F2] border border-stone-200/80 bg-white hover:border-[#0F766E]/40 transition shadow-2xs" data-target="ringkasan">
        Ringkasan Kinerja
      </button>

      <!-- 3. Analisis Produk Eboni -->
      <button type="button" class="top-nav-btn flex-shrink-0 whitespace-nowrap px-4 py-2 rounded-full font-medium text-gray-700 hover:text-[#0F766E] hover:bg-[#FAF7F2] border border-stone-200/80 bg-white hover:border-[#0F766E]/40 transition shadow-2xs" data-target="produk">
        Analisis Produk Eboni
      </button>

      <!-- 4. Channel & Wilayah -->
      <button type="button" class="top-nav-btn flex-shrink-0 whitespace-nowrap px-4 py-2 rounded-full font-medium text-gray-700 hover:text-[#0F766E] hover:bg-[#FAF7F2] border border-stone-200/80 bg-white hover:border-[#0F766E]/40 transition shadow-2xs" data-target="channel">
        Channel & Wilayah
      </button>

      <!-- 5. Perilaku Konsumen -->
      <button type="button" class="top-nav-btn flex-shrink-0 whitespace-nowrap px-4 py-2 rounded-full font-medium text-gray-700 hover:text-[#0F766E] hover:bg-[#FAF7F2] border border-stone-200/80 bg-white hover:border-[#0F766E]/40 transition shadow-2xs" data-target="pelanggan">
        Perilaku Konsumen
      </button>

      <!-- 6. Operasional & HPP -->
      <button type="button" class="top-nav-btn flex-shrink-0 whitespace-nowrap px-4 py-2 rounded-full font-medium text-gray-700 hover:text-[#0F766E] hover:bg-[#FAF7F2] border border-stone-200/80 bg-white hover:border-[#0F766E]/40 transition shadow-2xs" data-target="operasional">
        Operasional & HPP
      </button>

      <!-- 7. Prediksi 12 Bulan -->
      <button type="button" class="top-nav-btn flex-shrink-0 whitespace-nowrap px-4 py-2 rounded-full font-medium text-gray-700 hover:text-[#0F766E] hover:bg-[#FAF7F2] border border-stone-200/80 bg-white hover:border-[#0F766E]/40 transition shadow-2xs" data-target="prediksi">
        Prediksi 12 Bulan
      </button>

    </nav>

    <!-- Sisi Kanan: Status & Account Action -->
    <div class="flex items-center gap-2 sm:gap-3 flex-shrink-0">

      <!-- CLEAR DISTINCTION: BEFORE LOGIN (PUBLIC) vs AFTER LOGIN (ADMIN) -->
      <?php if ($isAdmin): ?>
        <!-- Admin Logged In Profile Strip -->
        <div class="flex items-center gap-2 sm:gap-3 flex-shrink-0">
          <div class="hidden sm:flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-bold bg-emerald-100 text-emerald-800 border border-emerald-300 shadow-2xs">
            <span class="w-2 h-2 rounded-full bg-emerald-500 animate-pulse"></span>
            <span>Sesi Admin</span>
          </div>

          <div class="flex items-center gap-2">
            <div class="w-8 h-8 rounded-full bg-[#0F766E] text-white flex items-center justify-center font-bold text-xs shadow-2xs" title="Login sebagai: admin">
              A
            </div>
            <form action="<?= $base ?>/api/v1/auth/logout" method="POST" class="inline" onsubmit="return confirm('Keluar dari sesi Administrator?')">
              <button type="submit" class="px-3 py-1.5 rounded-full text-xs font-semibold bg-rose-50 text-rose-700 hover:bg-rose-100 border border-rose-200 transition flex items-center gap-1">
                <svg class="w-3.5 h-3.5 text-rose-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"/>
                </svg>
                <span>Keluar</span>
              </button>
            </form>
          </div>
        </div>
      <?php else: ?>
        <!-- Public Visitor Mode Action -->
        <div class="flex items-center flex-shrink-0">
          <a href="<?= $base ?>/login" class="inline-flex items-center gap-1.5 px-4 py-2 rounded-full text-xs font-semibold bg-[#0F766E] hover:bg-[#0D6E6E] text-white shadow-sm hover:shadow transition">
            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/>
            </svg>
            <span>Masuk</span>
          </a>
        </div>
      <?php endif; ?>

    </div>

  </div>
</header>
