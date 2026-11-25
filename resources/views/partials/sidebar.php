<?php
$base = dirname($_SERVER['SCRIPT_NAME'] ?? '');
if ($base === '/' || $base === '\\') $base = '';
$isAdmin = $is_admin ?? false;
$activePage = $active_page ?? 'dashboard';
?>

<!-- Backdrop Mobile -->
<div id="sidebar-backdrop" class="fixed inset-0 bg-black/60 backdrop-blur-xs z-40 hidden md:hidden transition-opacity"></div>

<!-- Left Sidebar (Standard Professional Dark Admin Dashboard Layout - Sticky & Fixed on Scroll) -->
<aside id="main-sidebar" class="fixed inset-y-0 left-0 z-50 w-64 bg-[#072F2D] text-white flex flex-col justify-between transition-transform duration-300 ease-in-out -translate-x-full md:translate-x-0 md:sticky md:top-0 md:self-start md:h-screen md:max-h-screen flex-shrink-0 border-r border-[#0D4542] shadow-2xl md:shadow-none font-sans select-none overflow-hidden">

  <!-- Top: Brand Header & Session Mode Indicator -->
  <div class="h-16 px-5 flex items-center justify-between border-b border-[#0D4542] bg-[#052422] flex-shrink-0">
    <a href="<?= $base ?>/" class="flex items-center gap-2.5 group">
      <!-- Logo Emblem -->
      <div class="w-10 h-10 rounded-xl bg-gradient-to-br from-[#0F766E] to-[#0A4F4A] text-white flex items-center justify-center font-serif font-bold text-xl shadow-xs group-hover:scale-105 transition-transform flex-shrink-0">
        <span>E</span>
      </div>
      <div class="flex flex-col">
        <span class="text-white font-bold text-base tracking-tight leading-tight group-hover:text-emerald-300 transition-colors">
          EbonyCraft Palu
        </span>
        <span class="text-[11px] text-emerald-300/80 leading-none mt-1">
          UMKM Sumber Urip • Palu, Sulteng
        </span>
      </div>
    </a>

    <!-- Close button on Mobile -->
    <button id="btn-close-sidebar" class="md:hidden text-gray-400 hover:text-white hover:bg-white/10 p-1.5 rounded-lg transition" title="Tutup Navigasi">
      <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
      </svg>
    </button>
  </div>

  <!-- Middle: Main Navigation List (Scrolls independently if screen is short, flex-1) -->
  <div class="px-3 py-4 overflow-y-auto flex-1 space-y-5">
    
    <!-- Group 1: Navigation Menu -->
    <div>
      <div class="text-[10px] font-bold uppercase tracking-wider text-emerald-400/80 px-3 mb-2 font-mono flex items-center justify-between">
        <span>NAVIGASI DASHBOARD</span>
        <span class="text-[9px] text-emerald-300/60 font-mono">25 Chart</span>
      </div>

      <nav class="space-y-1 text-xs">
        <!-- 1. Semua -->
        <button type="button" class="sidebar-nav-btn active w-full flex items-center gap-3 px-3.5 py-2.5 rounded-xl font-semibold transition text-left bg-[#0F766E] text-white shadow-xs group" data-target="all">
          <svg class="w-4 h-4 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zM14 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z"/>
          </svg>
          <span class="flex-1">Semua</span>
        </button>

        <!-- 2. Ringkasan Kinerja -->
        <button type="button" class="sidebar-nav-btn w-full flex items-center gap-3 px-3.5 py-2.5 rounded-xl font-medium transition text-left text-gray-300 hover:text-white hover:bg-white/10 group" data-target="ringkasan">
          <svg class="w-4 h-4 flex-shrink-0 text-emerald-300/70 group-hover:text-emerald-300 transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6"/>
          </svg>
          <span class="flex-1">Ringkasan Kinerja</span>
        </button>

        <!-- 3. Analisis Produk Eboni -->
        <button type="button" class="sidebar-nav-btn w-full flex items-center gap-3 px-3.5 py-2.5 rounded-xl font-medium transition text-left text-gray-300 hover:text-white hover:bg-white/10 group" data-target="produk">
          <svg class="w-4 h-4 flex-shrink-0 text-emerald-300/70 group-hover:text-emerald-300 transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"/>
          </svg>
          <span class="flex-1">Analisis Produk Eboni</span>
        </button>

        <!-- 4. Channel & Wilayah -->
        <button type="button" class="sidebar-nav-btn w-full flex items-center gap-3 px-3.5 py-2.5 rounded-xl font-medium transition text-left text-gray-300 hover:text-white hover:bg-white/10 group" data-target="channel">
          <svg class="w-4 h-4 flex-shrink-0 text-emerald-300/70 group-hover:text-emerald-300 transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3.055 11H5a2 2 0 012 2v1a2 2 0 002 2 2 2 0 012 2v2.945M8 3.935V5.5A2.5 2.5 0 0010.5 8h.5a2 2 0 012 2 2 2 0 104 0 2 2 0 012-2h1.064M15 20.488V18a2 2 0 012-2h3.064M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
          </svg>
          <span class="flex-1">Channel & Wilayah</span>
        </button>

        <!-- 5. Perilaku Konsumen -->
        <button type="button" class="sidebar-nav-btn w-full flex items-center gap-3 px-3.5 py-2.5 rounded-xl font-medium transition text-left text-gray-300 hover:text-white hover:bg-white/10 group" data-target="pelanggan">
          <svg class="w-4 h-4 flex-shrink-0 text-emerald-300/70 group-hover:text-emerald-300 transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"/>
          </svg>
          <span class="flex-1">Perilaku Konsumen</span>
        </button>

        <!-- 6. Operasional & HPP -->
        <button type="button" class="sidebar-nav-btn w-full flex items-center gap-3 px-3.5 py-2.5 rounded-xl font-medium transition text-left text-gray-300 hover:text-white hover:bg-white/10 group" data-target="operasional">
          <svg class="w-4 h-4 flex-shrink-0 text-emerald-300/70 group-hover:text-emerald-300 transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6V4m0 2a2 2 0 100 4m0-4a2 2 0 110 4m-6 8a2 2 0 100-4m0 4a2 2 0 110-4m0 4v2m0-6V4m6 6v10m6-2a2 2 0 100-4m0 4a2 2 0 110-4m0 4v2m0-6V4"/>
          </svg>
          <span class="flex-1">Operasional & HPP</span>
        </button>

        <!-- 7. Prediksi 12 Bulan -->
        <button type="button" class="sidebar-nav-btn w-full flex items-center gap-3 px-3.5 py-2.5 rounded-xl font-medium transition text-left text-gray-300 hover:text-white hover:bg-white/10 group" data-target="prediksi">
          <svg class="w-4 h-4 flex-shrink-0 text-amber-400 group-hover:text-amber-300 transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 3v4M3 5h4M6 17v4m-2-2h4m5-16l2.286 6.857L21 12l-5.714 2.143L13 21l-2.286-6.857L5 12l5.714-2.143L13 3z"/>
          </svg>
          <span class="flex-1">Prediksi 12 Bulan</span>
        </button>
      </nav>
    </div>

    <!-- Group 2: Management & Tool Actions -->
    <div class="pt-2 border-t border-[#0D4542]">
      <div class="text-[10px] font-bold uppercase tracking-wider text-emerald-400/80 px-3 mb-2 font-mono flex items-center justify-between">
        <span>KONTROL SISTEM</span>
        <span class="bg-emerald-500/20 text-emerald-300 text-[9px] px-1.5 py-0.5 rounded font-mono">ADMIN</span>
      </div>

      <div class="space-y-1">
        <!-- Action 1: Re-run Forecast -->
        <button type="button" class="w-full flex items-center gap-2.5 px-3 py-2 rounded-xl text-xs font-semibold text-white bg-white/10 hover:bg-emerald-600/40 border border-white/10 transition text-left" onclick="document.querySelector('#section-prediksi')?.scrollIntoView({behavior: 'smooth'})">
          <svg class="w-4 h-4 text-emerald-300 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"/>
          </svg>
          <span class="flex-1">Hitung Ulang Prediksi</span>
          <span class="text-[9px] bg-emerald-500/30 text-emerald-200 px-1.5 py-0.5 rounded font-mono">Run</span>
        </button>

        <!-- Action 2: CSV Upload -->
        <button type="button" class="w-full flex items-center gap-2.5 px-3 py-2 rounded-xl text-xs font-medium text-gray-300 hover:text-white hover:bg-white/10 transition text-left" onclick="document.querySelector('#import-form')?.scrollIntoView({behavior: 'smooth'})">
          <svg class="w-4 h-4 text-emerald-300 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-8l-4-4m0 0L8 8m4-4v12"/>
          </svg>
          <span class="flex-1">Unggah Transaksi CSV</span>
          <span class="text-[9px] text-gray-400 font-mono">.csv</span>
        </button>

        <!-- Action 3: Clear Cache -->
        <button type="button" class="w-full flex items-center gap-2.5 px-3 py-2 rounded-xl text-xs font-medium text-gray-300 hover:text-white hover:bg-white/10 transition text-left" id="btn-sidebar-clear-cache">
          <svg class="w-4 h-4 text-emerald-300 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
          </svg>
          <span class="flex-1">Bersihkan Cache JSON</span>
          <span class="text-[9px] text-gray-400 font-mono">Flush</span>
        </button>
      </div>
    </div>

  </div>

  <!-- Bottom: Footer Branding -->
  <div class="p-3 border-t border-[#0D4542] bg-[#052422] flex-shrink-0 text-[10px] text-center text-emerald-300/50">
    EbonyCraft • Kota Palu, Sulteng
  </div>

</aside>
