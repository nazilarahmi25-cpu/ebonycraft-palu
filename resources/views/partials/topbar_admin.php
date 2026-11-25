<?php
$base = dirname($_SERVER['SCRIPT_NAME'] ?? '');
if ($base === '/' || $base === '\\') $base = '';
?>
<header class="sticky top-0 z-30 bg-white/95 backdrop-blur-md border-b border-[#EBE2D5] shadow-xs px-4 sm:px-6 lg:px-8 h-16 flex items-center justify-between gap-4">
  <!-- Sisi Kiri: Hamburger Toggle & Breadcrumb -->
  <div class="flex items-center gap-3">
    <button type="button" id="btn-toggle-sidebar" class="p-2 rounded-xl text-gray-600 hover:text-gray-900 hover:bg-[#FAF7F2] border border-[#E8DCCB] transition" title="Buka/Tutup Sidebar Menu">
      <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/>
      </svg>
    </button>
    <div class="flex items-center gap-2 text-xs">
      <span class="text-gray-400 font-medium">Dashboard</span>
      <span class="text-gray-300">/</span>
      <span class="font-bold text-gray-800">Konsol Administrator UMKM</span>
    </div>
  </div>

  <!-- Sisi Kanan: Status & User Session -->
  <div class="flex items-center gap-2 sm:gap-3">
    <!-- Shortcut ke Portal Publik -->
    <a href="<?= $base ?>/" class="hidden sm:inline-flex items-center gap-1.5 px-3 py-1.5 rounded-full text-xs font-semibold text-[#0F766E] bg-[#0F766E]/10 hover:bg-[#0F766E]/20 border border-[#0F766E]/20 transition" target="_blank" title="Buka tampilan publik di tab baru">
      <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"/>
      </svg>
      <span>Lihat Tampilan Publik</span>
    </a>

    <!-- Status Sesi Admin -->
    <div class="hidden md:flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-bold bg-emerald-100 text-emerald-800 border border-emerald-300 shadow-2xs">
      <span class="w-2 h-2 rounded-full bg-emerald-500 animate-pulse"></span>
      <span>Sesi Admin</span>
    </div>

    <!-- Avatar & Logout -->
    <div class="flex items-center gap-2 pl-2 border-l border-[#EBE2D5]">
      <div class="w-8 h-8 rounded-full bg-[#0F766E] text-white flex items-center justify-center font-bold text-xs shadow-2xs" title="Login sebagai: admin">
        A
      </div>
      <form action="<?= $base ?>/api/v1/auth/logout" method="POST" class="inline" onsubmit="return confirm('Keluar dari sesi Administrator?')">
        <button type="submit" class="px-3 py-1.5 rounded-full text-xs font-semibold bg-rose-50 text-rose-700 hover:bg-rose-100 border border-rose-200 transition flex items-center gap-1">
          <svg class="w-3.5 h-3.5 text-rose-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"/>
          </svg>
          <span class="hidden sm:inline">Keluar</span>
        </button>
      </form>
    </div>
  </div>
</header>
