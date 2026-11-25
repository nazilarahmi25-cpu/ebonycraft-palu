<?php
$base = dirname($_SERVER['SCRIPT_NAME'] ?? '');
if ($base === '/' || $base === '\\') $base = '';
?>
<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Masuk Konsol Admin — EbonyCraft Palu</title>

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
              500: '#0F766E',
              600: '#0D6E6E',
              700: '#0B5E5E',
              800: '#094E4E',
              900: '#063A3A',
            },
            coral: {
              500: '#E76F51',
              600: '#D85A3C',
            },
            cream: {
              50: '#FAF7F2',
              100: '#F5EFE6',
              200: '#EBE2D5',
              300: '#DED1BF',
            },
            ebony: {
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
</head>
<body class="bg-[#FAF7F2] text-[#2A211B] font-sans antialiased min-h-screen flex items-center justify-center p-4 sm:p-6 lg:p-8">

  <!-- Main Container: 2-Column Split Luxury Card -->
  <div class="w-full max-w-5xl bg-white rounded-3xl shadow-2xl border border-[#E8DCCB] overflow-hidden grid grid-cols-1 lg:grid-cols-12 min-h-[640px]">
    
    <!-- Left Showcase Panel (Woodcraft & Analytics Brand Showcase) -->
    <div class="lg:col-span-6 bg-gradient-to-br from-[#072F2D] via-[#0E4E49] to-[#1C1410] p-8 sm:p-12 text-white flex flex-col justify-between relative overflow-hidden">
      <!-- Ambient Glows -->
      <div class="absolute -top-24 -left-24 w-80 h-80 bg-[#14B8A6]/20 rounded-full blur-3xl pointer-events-none"></div>
      <div class="absolute -bottom-24 -right-24 w-80 h-80 bg-[#E76F51]/15 rounded-full blur-3xl pointer-events-none"></div>

      <!-- Top Brand Tag -->
      <div class="relative z-10 space-y-4">
        <a href="<?= $base ?>/" class="inline-flex items-center gap-3 group">
          <div class="w-11 h-11 rounded-xl bg-gradient-to-br from-[#0F766E] to-[#14B8A6] text-white flex items-center justify-center font-serif font-bold text-2xl shadow-md group-hover:scale-105 transition-transform">
            E
          </div>
          <div>
            <span class="font-serif font-bold text-xl tracking-tight text-white block">EbonyCraft Palu</span>
            <span class="text-xs text-[#A7F3D0] tracking-wide">UMKM Sumber Urip • Sulawesi Tengah</span>
          </div>
        </a>

        <div class="pt-6">
          <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-semibold bg-white/10 backdrop-blur-md border border-white/20 text-[#5EEAD4]">
            <span class="w-2 h-2 rounded-full bg-emerald-400 animate-pulse"></span>
            <span>Konsol Manajemen & Prediksi Deret Waktu</span>
          </span>

          <h2 class="font-serif text-2xl sm:text-3xl font-bold leading-snug text-white mt-4">
            Menghubungkan Tradisi Kriya Kayu Eboni dengan Kecerdasan Analitik Modern
          </h2>
          <p class="text-xs sm:text-sm text-gray-200/90 mt-3 leading-relaxed">
            Akses khusus administrator untuk mengontrol kalkulasi 3 algoritma peramalan permintaan (Holt-Winters, Regresi Musiman, SMA) dan mengelola data transaksi penjualan UMKM.
          </p>
        </div>

        <!-- Key Feature Bullet Points -->
        <div class="space-y-2.5 pt-4 text-xs text-gray-200">
          <div class="flex items-center gap-2.5">
            <span class="w-5 h-5 rounded-full bg-teal-500/20 text-teal-300 flex items-center justify-center font-bold text-xs">✓</span>
            <span>Kontrol Algoritma Prediksi 12 Bulan (MAPE 7.42%)</span>
          </div>
          <div class="flex items-center gap-2.5">
            <span class="w-5 h-5 rounded-full bg-teal-500/20 text-teal-300 flex items-center justify-center font-bold text-xs">✓</span>
            <span>Unggah & Validasi Berkas Transaksi CSV Harian</span>
          </div>
          <div class="flex items-center gap-2.5">
            <span class="w-5 h-5 rounded-full bg-teal-500/20 text-teal-300 flex items-center justify-center font-bold text-xs">✓</span>
            <span>Otentikasi Aman (BCrypt Password & Token Anti-CSRF)</span>
          </div>
        </div>
      </div>

      <!-- Bottom: Return Link -->
      <div class="relative z-10 pt-8 border-t border-white/15">
        <a href="<?= $base ?>/" class="inline-flex items-center gap-2 text-xs font-medium text-[#A7F3D0] hover:text-white transition">
          <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
          </svg>
          <span>Kembali ke Dashboard Publik (25 Chart)</span>
        </a>
      </div>
    </div>

    <!-- Right Login Form Panel -->
    <div class="lg:col-span-6 p-8 sm:p-12 flex flex-col justify-between bg-white">
      <div>
        <!-- Top Navigation Status -->
        <div class="flex items-center justify-between pb-6 border-b border-[#F5EFE6]">
          <span class="text-xs font-semibold text-[#78716C] uppercase tracking-wider font-mono">AUTENTIKASI SISTEM</span>
          <a href="<?= $base ?>/" class="text-xs text-[#0F766E] hover:underline font-medium">Buka Dashboard Publik →</a>
        </div>

        <div class="mt-6">
          <h3 class="font-serif text-2xl sm:text-3xl font-bold text-[#1C1410]">Masuk Konsol Admin</h3>
          <p class="text-xs sm:text-sm text-[#78716C] mt-1.5 leading-relaxed">
            Silakan masukkan kredensial administrator Anda untuk membuka hak akses kalkulasi prediksi dan manajemen data.
          </p>
        </div>

        <!-- Alert Notification Box -->
        <div id="login-alert" class="hidden mt-4 p-3.5 rounded-xl text-xs font-medium border animate-in fade-in"></div>

        <!-- Login Form -->
        <form id="login-form" class="mt-6 space-y-4">
          <input type="hidden" name="csrf_token" id="csrf_token" value="<?= \App\Core\Csrf::token() ?>">

          <!-- Username Input -->
          <div>
            <label for="username" class="block text-xs font-semibold text-[#44403C] uppercase tracking-wider mb-1.5">
              Username
            </label>
            <div class="relative">
              <span class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none text-gray-400">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                </svg>
              </span>
              <input type="text" name="username" id="username" required autocomplete="username" placeholder="Masukkan username" class="w-full pl-10 pr-4 py-2.5 bg-[#FAF7F2] border border-[#E8DCCB] rounded-xl text-xs sm:text-sm text-gray-900 placeholder-gray-400 outline-none focus:border-[#0F766E] focus:ring-1 focus:ring-[#0F766E] transition">
            </div>
          </div>

          <!-- Password Input with Show/Hide Toggle -->
          <div>
            <div class="flex items-center justify-between mb-1.5">
              <label for="password" class="block text-xs font-semibold text-[#44403C] uppercase tracking-wider">
                Kata Sandi (Password)
              </label>
            </div>
            <div class="relative">
              <span class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none text-gray-400">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/>
                </svg>
              </span>
              <input type="password" name="password" id="password" required autocomplete="current-password" placeholder="••••••••" class="w-full pl-10 pr-10 py-2.5 bg-[#FAF7F2] border border-[#E8DCCB] rounded-xl text-xs sm:text-sm text-gray-900 placeholder-gray-400 outline-none focus:border-[#0F766E] focus:ring-1 focus:ring-[#0F766E] transition">
              <button type="button" id="btn-toggle-password" class="absolute inset-y-0 right-0 pr-3.5 flex items-center text-gray-400 hover:text-gray-600 transition" title="Tampilkan/Sembunyikan Sandi">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                </svg>
              </button>
            </div>
          </div>

          <!-- Submit Button -->
          <div class="pt-2">
            <button type="submit" id="btn-submit-login" class="w-full py-3 px-4 rounded-xl bg-[#0F766E] hover:bg-[#0D6E6E] text-white font-semibold text-xs sm:text-sm shadow-md transition flex items-center justify-center gap-2 group">
              <svg id="btn-icon" class="w-4 h-4 group-hover:translate-x-0.5 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"/>
              </svg>
              <span id="btn-text">Masuk ke Dashboard Admin</span>
            </button>
          </div>
        </form>
      </div>

      <!-- Footer Info -->
      <div class="pt-8 border-t border-[#F5EFE6] text-center text-[11px] text-[#A89F91]">
        © <?= date('Y') ?> EbonyCraft Palu. Hak akses khusus administrator UMKM Sumber Urip.
      </div>
    </div>

  </div>

  <script>
    // 1. Show/Hide Password Toggle
    const toggleBtn = document.getElementById('btn-toggle-password');
    const pwdInput = document.getElementById('password');
    toggleBtn?.addEventListener('click', () => {
      const type = pwdInput.getAttribute('type') === 'password' ? 'text' : 'password';
      pwdInput.setAttribute('type', type);
    });

    // 3. Form Submit with AJAX
    const loginForm = document.getElementById('login-form');
    const alertBox = document.getElementById('login-alert');
    const submitBtn = document.getElementById('btn-submit-login');
    const btnText = document.getElementById('btn-text');

    loginForm.addEventListener('submit', async (e) => {
      e.preventDefault();

      alertBox.classList.add('hidden');
      alertBox.className = 'hidden';
      submitBtn.disabled = true;
      btnText.textContent = 'Memverifikasi...';

      const formData = new FormData(loginForm);
      const payload = Object.fromEntries(formData.entries());

      try {
        const res = await fetch('<?= $base ?>/api/v1/auth/login', {
          method: 'POST',
          headers: { 'Content-Type': 'application/json' },
          body: JSON.stringify(payload)
        });

        const data = await res.json();

        if (res.ok && data.status === 'success') {
          alertBox.textContent = '✓ Login berhasil! Mengalihkan ke Dashboard Admin...';
          alertBox.className = 'mt-4 p-3.5 rounded-xl text-xs font-semibold bg-emerald-50 text-emerald-800 border border-emerald-300 block animate-in fade-in';
          setTimeout(() => {
            window.location.href = '<?= $base ?>/';
          }, 800);
        } else {
          alertBox.textContent = '✕ ' + (data.error?.message || 'Username atau kata sandi tidak sesuai.');
          alertBox.className = 'mt-4 p-3.5 rounded-xl text-xs font-semibold bg-rose-50 text-rose-800 border border-rose-300 block animate-in fade-in';
          submitBtn.disabled = false;
          btnText.textContent = 'Masuk ke Dashboard Admin';
        }
      } catch (err) {
        alertBox.textContent = '✕ Terjadi kesalahan koneksi server.';
        alertBox.className = 'mt-4 p-3.5 rounded-xl text-xs font-semibold bg-rose-50 text-rose-800 border border-rose-300 block animate-in fade-in';
        submitBtn.disabled = false;
        btnText.textContent = 'Masuk ke Dashboard Admin';
      }
    });
  </script>
</body>
</html>
