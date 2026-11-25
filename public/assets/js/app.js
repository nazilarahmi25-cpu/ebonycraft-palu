// APP MAIN CONTROLLER (app.js) - Top Navigation, 25 Charts Manager & Data Table Modal
import { api } from './api.js';
import { chartRegistry } from './charts/registry.js';
import { formatRupiah, formatCompactRupiah, formatPercent } from './format.js';

class EbonyApp {
  constructor() {
    this.activeCharts = new Map();
    this.chartDataMap = new Map();
    this.initialTarget = document.body.dataset.page || 'all';
    this.abortController = null;
    this.init();
  }

  init() {
    this.setupSidebarToggle();
    this.setupTopNavButtons();
    this.setupFilterEvents();
    this.setupHeroEvents();
    this.setupChartActions();
    this.setupTableModal();
    this.setupAssistant();
    this.setupThemeToggle();
    this.setupKeyboardShortcuts();
    this.setupAdminActions();
    this.loadFilters();
    this.loadAllData();
  }

  setupAdminActions() {
    const getCsrfToken = () => {
      const input = document.querySelector('input[name="csrf_token"]');
      return input ? input.value : '';
    };

    const showToast = (message, isError = false) => {
      let toast = document.querySelector('#global-admin-toast');
      if (!toast) {
        toast = document.createElement('div');
        toast.id = 'global-admin-toast';
        document.body.appendChild(toast);
      }
      toast.className = `fixed bottom-6 left-6 z-50 max-w-sm px-4 py-3 rounded-2xl shadow-2xl text-xs font-semibold flex items-center gap-2.5 transition-all duration-300 transform translate-y-0 opacity-100 ${
        isError ? 'bg-rose-800 text-white border border-rose-600' : 'bg-[#0F766E] text-white border border-teal-500'
      }`;
      toast.innerHTML = `<span>${isError ? '✕' : '✓'}</span><span>${message}</span>`;
      setTimeout(() => {
        toast.className = toast.className.replace('translate-y-0 opacity-100', 'translate-y-12 opacity-0 pointer-events-none');
      }, 4000);
    };

    // Run Forecast buttons
    const handleRunForecast = async (btn) => {
      if (!btn) return;
      const statusEl = document.querySelector('#forecast-status');
      const originalText = btn.innerHTML;
      btn.disabled = true;
      btn.classList.add('opacity-75');
      if (statusEl) {
        statusEl.textContent = 'Menghitung kalkulasi 3 model algoritma... Mohon tunggu...';
        statusEl.className = 'mt-2 text-xs font-medium text-amber-600 animate-pulse';
      }
      showToast('Memulai kalkulasi model Holt-Winters, Regresi Musiman, & SMA...');

      try {
        const token = getCsrfToken();
        const data = await api.runForecast(token);
        if (statusEl) {
          statusEl.textContent = `✓ Sukses! Model ${data.selected_model} terpilih (MAPE: ${data.mape}%). Memuat ulang data...`;
          statusEl.className = 'mt-2 text-xs font-medium text-emerald-600';
        }
        showToast(`Model ${data.selected_model} berhasil dihitung (MAPE: ${data.mape}%).`);
        setTimeout(() => window.location.reload(), 1200);
      } catch (err) {
        if (statusEl) {
          statusEl.textContent = 'Gagal: ' + err.message;
          statusEl.className = 'mt-2 text-xs font-medium text-rose-600';
        }
        showToast(err.message, true);
        btn.disabled = false;
        btn.classList.remove('opacity-75');
        btn.innerHTML = originalText;
      }
    };

    document.querySelector('#btn-run-forecast')?.addEventListener('click', (e) => handleRunForecast(e.currentTarget));
    document.querySelector('#btn-admin-top-forecast')?.addEventListener('click', (e) => handleRunForecast(e.currentTarget));

    // Clear Cache buttons
    const handleClearCache = async (btn) => {
      if (!btn) return;
      const originalText = btn.innerHTML;
      btn.disabled = true;
      btn.classList.add('opacity-75');
      showToast('Membersihkan cache JSON sistem...');

      try {
        const token = getCsrfToken();
        const res = await api.clearCache(token);
        showToast(`✓ ${res.message || 'Cache berhasil dibersihkan!'}`);
        setTimeout(() => window.location.reload(), 800);
      } catch (err) {
        showToast(err.message, true);
        btn.disabled = false;
        btn.classList.remove('opacity-75');
        btn.innerHTML = originalText;
      }
    };

    document.querySelector('#btn-sidebar-clear-cache')?.addEventListener('click', (e) => handleClearCache(e.currentTarget));
    document.querySelector('#btn-admin-top-clear-cache')?.addEventListener('click', (e) => handleClearCache(e.currentTarget));

    // Import CSV Form AJAX Handler
    const importForm = document.querySelector('#import-form');
    if (importForm) {
      importForm.addEventListener('submit', async (e) => {
        e.preventDefault();
        const submitBtn = document.querySelector('#btn-submit-import');
        const statusEl = document.querySelector('#import-status');
        const fileInput = document.querySelector('#csv-file-input');

        if (!fileInput || !fileInput.files.length) {
          showToast('Pilih berkas CSV terlebih dahulu.', true);
          return;
        }

        if (submitBtn) {
          submitBtn.disabled = true;
          submitBtn.classList.add('opacity-75');
        }
        if (statusEl) {
          statusEl.textContent = 'Mengunggah & memvalidasi berkas CSV...';
          statusEl.className = 'mt-2 text-xs font-medium text-amber-600 animate-pulse';
        }

        const formData = new FormData(importForm);

        try {
          const res = await fetch(importForm.action, {
            method: 'POST',
            body: formData,
          });
          const data = await res.json();
          if (res.ok && data.status === 'success') {
            if (statusEl) {
              statusEl.textContent = `✓ Sukses! Berhasil mengimpor ${data.imported_rows ?? data.total_rows ?? ''} baris data transaksi.`;
              statusEl.className = 'mt-2 text-xs font-medium text-emerald-600';
            }
            showToast('✓ Impor CSV berhasil! Memuat ulang visualisasi...');
            setTimeout(() => window.location.reload(), 1500);
          } else {
            const msg = data.error?.message || 'Gagal mengimpor file CSV.';
            if (statusEl) {
              statusEl.textContent = '✕ ' + msg;
              statusEl.className = 'mt-2 text-xs font-medium text-rose-600';
            }
            showToast(msg, true);
            if (submitBtn) {
              submitBtn.disabled = false;
              submitBtn.classList.remove('opacity-75');
            }
          }
        } catch (err) {
          if (statusEl) {
            statusEl.textContent = '✕ Gagal menghubungi server.';
            statusEl.className = 'mt-2 text-xs font-medium text-rose-600';
          }
          showToast('Gagal menghubungi server.', true);
          if (submitBtn) {
            submitBtn.disabled = false;
            submitBtn.classList.remove('opacity-75');
          }
        }
      });
    }
  }

  setupSidebarToggle() {
    const sidebar = document.querySelector('#main-sidebar');
    const toggleBtn = document.querySelector('#btn-toggle-sidebar');
    const closeBtn = document.querySelector('#btn-close-sidebar');
    const backdrop = document.querySelector('#sidebar-backdrop');

    if (!sidebar || !toggleBtn) return;

    const openSidebar = () => {
      sidebar.classList.remove('-translate-x-full');
      backdrop?.classList.remove('hidden');
    };

    const closeSidebar = () => {
      sidebar.classList.add('-translate-x-full');
      backdrop?.classList.add('hidden');
    };

    toggleBtn.addEventListener('click', () => {
      if (window.innerWidth < 768) {
        if (sidebar.classList.contains('-translate-x-full')) {
          openSidebar();
        } else {
          closeSidebar();
        }
      } else {
        sidebar.classList.toggle('md:hidden');
        setTimeout(() => window.dispatchEvent(new Event('resize')), 200);
      }
    });

    closeBtn?.addEventListener('click', closeSidebar);
    backdrop?.addEventListener('click', closeSidebar);
  }

  setupTopNavButtons() {
    const navButtons = document.querySelectorAll('.top-nav-btn, .sidebar-nav-btn');
    if (!navButtons.length) return;

    let initialBtn = document.querySelector(`.top-nav-btn[data-target="${this.initialTarget}"], .sidebar-nav-btn[data-target="${this.initialTarget}"]`);
    if (!initialBtn) {
      initialBtn = document.querySelector('.top-nav-btn[data-target="all"], .sidebar-nav-btn[data-target="all"]');
    }
    if (initialBtn) {
      this.switchSection(initialBtn.dataset.target, initialBtn);
    }

    navButtons.forEach((btn) => {
      btn.addEventListener('click', () => {
        const target = btn.dataset.target;
        this.switchSection(target, btn);
      });
    });
  }

  switchSection(target, activeBtn) {
    const navButtons = document.querySelectorAll('.top-nav-btn, .sidebar-nav-btn');
    navButtons.forEach((b) => {
      const badge = b.querySelector('.nav-badge, .sidebar-badge');
      const isSidebar = b.classList.contains('sidebar-nav-btn');

      if (b.dataset.target === target) {
        b.classList.add('bg-[#0F766E]', 'text-white', 'shadow-xs', 'font-semibold', 'active');
        if (!isSidebar) {
          b.classList.add('border-[#0F766E]');
          b.classList.remove('text-gray-700', 'hover:text-[#0F766E]', 'hover:bg-[#FAF7F2]', 'bg-white', 'border-stone-200/80', 'font-medium');
        } else {
          b.classList.remove('text-gray-300', 'hover:text-white', 'hover:bg-white/10', 'font-medium');
        }
        if (badge) {
          badge.className = 'nav-badge text-[10px] bg-white/20 text-white px-2 py-0.5 rounded-full font-mono font-medium';
        }
      } else {
        b.classList.remove('bg-[#0F766E]', 'text-white', 'shadow-xs', 'font-semibold', 'active');
        if (isSidebar) {
          b.classList.add('text-gray-300', 'hover:text-white', 'hover:bg-white/10', 'font-medium');
          b.classList.remove('bg-white', 'border-stone-200/80', 'text-gray-700', 'border-[#0F766E]');
        } else {
          b.classList.add('text-gray-700', 'hover:text-[#0F766E]', 'hover:bg-[#FAF7F2]', 'bg-white', 'border-stone-200/80', 'font-medium');
          b.classList.remove('border-[#0F766E]');
        }
        if (badge) {
          if (b.dataset.target === 'prediksi') {
            badge.className = 'nav-badge text-[10px] bg-amber-50 text-amber-700 border border-amber-200 px-1.5 py-0.5 rounded-md font-mono font-medium';
          } else {
            badge.className = 'nav-badge text-[10px] text-gray-500 bg-[#FAF7F2] border border-[#E8DCCB] px-1.5 py-0.5 rounded-md font-mono';
          }
        }
      }
    });

    const topbarLabel = document.querySelector('#topbar-section-label');
    if (topbarLabel) {
      const labelMap = {
        'all': 'Semua',
        'ringkasan': 'Ringkasan Kinerja (C01–C05)',
        'produk': 'Analisis Produk Eboni (C06–C10)',
        'channel': 'Channel & Wilayah (C11–C14)',
        'pelanggan': 'Perilaku Konsumen (C15–C18)',
        'operasional': 'Operasional & HPP (C19–C21)',
        'prediksi': 'Prediksi 12 Bulan (C22–C25)',
      };
      topbarLabel.textContent = labelMap[target] || 'Semua';
    }

    const sections = document.querySelectorAll('.dashboard-section');

    if (target === 'all') {
      sections.forEach((sec) => {
        sec.style.display = 'block';
      });
      window.scrollTo({ top: 0, behavior: 'smooth' });
    } else {
      sections.forEach((sec) => {
        if (sec.dataset.section === target) {
          sec.style.display = 'block';
          sec.scrollIntoView({ behavior: 'smooth', block: 'start' });
        } else {
          sec.style.display = 'none';
        }
      });
    }

    // Trigger window resize so ApexCharts recalculates responsive dimensions
    setTimeout(() => {
      window.dispatchEvent(new Event('resize'));
    }, 150);
  }

  getFilters() {
    const params = new URLSearchParams(window.location.search);
    const filters = {};
    for (const [k, v] of params.entries()) {
      if (v) filters[k] = v;
    }
    return filters;
  }

  setFilters(newFilters) {
    const url = new URL(window.location);
    for (const [k, v] of Object.entries(newFilters)) {
      if (v) {
        url.searchParams.set(k, v);
      } else {
        url.searchParams.delete(k);
      }
    }
    window.history.pushState({}, '', url);
    this.loadAllData();
  }

  setupFilterEvents() {
    const form = document.querySelector('#filter-form');
    if (!form) return;

    let debounceTimer = null;
    form.addEventListener('change', () => {
      clearTimeout(debounceTimer);
      debounceTimer = setTimeout(() => {
        const formData = new FormData(form);
        const filters = Object.fromEntries(formData.entries());
        this.setFilters(filters);
      }, 300);
    });

    const resetBtn = document.querySelector('#btn-reset-filters');
    if (resetBtn) {
      resetBtn.addEventListener('click', () => {
        form.reset();
        window.history.pushState({}, '', window.location.pathname);
        this.loadAllData();
      });
    }
  }

  setupHeroEvents() {
    const heroBtn = document.querySelector('#btn-hero-search');
    const heroInput = document.querySelector('#hero-search-input');
    const heroSelect = document.querySelector('#hero-category-select');

    const handleSearch = () => {
      const q = heroInput?.value.trim().toLowerCase();
      const cat = heroSelect?.value;

      if (cat) {
        const catSelect = document.querySelector('#filter-category');
        if (catSelect) catSelect.value = cat;
        this.setFilters({ category_id: cat });
      }

      if (q) {
        // Find matching charts and highlight or scroll to them
        const cards = document.querySelectorAll('.chart-card');
        let firstMatch = null;
        cards.forEach((card) => {
          const text = card.textContent.toLowerCase();
          if (text.includes(q)) {
            card.classList.add('ring-2', 'ring-[#0F766E]', 'ring-offset-2');
            if (!firstMatch) firstMatch = card;
            setTimeout(() => card.classList.remove('ring-2', 'ring-[#0F766E]', 'ring-offset-2'), 4000);
          }
        });
        if (firstMatch) {
          firstMatch.scrollIntoView({ behavior: 'smooth', block: 'center' });
        }
      }
    };

    heroBtn?.addEventListener('click', handleSearch);
    heroInput?.addEventListener('keydown', (e) => {
      if (e.key === 'Enter') handleSearch();
    });
  }

  setupChartActions() {
    document.addEventListener('click', (e) => {
      // Handle Fullscreen button
      const fsBtn = e.target.closest('[data-action="fullscreen"]');
      if (fsBtn) {
        const card = fsBtn.closest('.chart-card');
        if (!document.fullscreenElement) {
          card.requestFullscreen?.().catch(() => {});
        } else {
          document.exitFullscreen?.().catch(() => {});
        }
        return;
      }

      // Handle Table View button [📋 Tabel]
      const tableBtn = e.target.closest('.btn-table-view');
      if (tableBtn) {
        const card = tableBtn.closest('.chart-card');
        const cid = card?.dataset.chartId;
        if (cid) {
          this.showTableModal(cid, card);
        }
        return;
      }
    });
  }

  setupTableModal() {
    const modal = document.querySelector('#table-modal');
    const closeBtn = document.querySelector('#btn-close-table-modal');
    const footerClose = document.querySelector('#btn-modal-close-footer');

    const closeModal = () => {
      modal?.classList.add('hidden');
    };

    closeBtn?.addEventListener('click', closeModal);
    footerClose?.addEventListener('click', closeModal);
    modal?.addEventListener('click', (e) => {
      if (e.target === modal) closeModal();
    });
  }

  showTableModal(chartId, cardElement) {
    const data = this.chartDataMap.get(chartId.toLowerCase());
    const modal = document.querySelector('#table-modal');
    const titleEl = document.querySelector('#table-modal-title');
    const subEl = document.querySelector('#table-modal-sub');
    const thead = document.querySelector('#table-modal-thead');
    const tbody = document.querySelector('#table-modal-tbody');

    if (!modal || !data) return;

    const chartTitle = cardElement?.querySelector('h3')?.textContent || `Chart ${chartId.toUpperCase()}`;
    const chartSub = cardElement?.querySelector('.chart-subtitle')?.textContent || '';

    titleEl.textContent = `Tabel Data: ${chartTitle}`;
    subEl.textContent = chartSub;

    // Build Table Header & Rows
    let headers = ['No', 'Kategori / Periode'];
    let rows = [];

    if (data.categories && data.series) {
      const isMultiSeries = Array.isArray(data.series) && typeof data.series[0] === 'object' && 'name' in data.series[0];

      if (isMultiSeries) {
        data.series.forEach((s) => headers.push(s.name));
        data.categories.forEach((cat, idx) => {
          const rowVals = [idx + 1, cat];
          data.series.forEach((s) => {
            const rawVal = s.data ? s.data[idx] : '-';
            rowVals.push(this.formatCellValue(rawVal, data.unit));
          });
          rows.push(rowVals);
        });
      } else if (Array.isArray(data.series)) {
        headers.push('Nilai');
        data.categories.forEach((cat, idx) => {
          const val = data.series[idx];
          rows.push([idx + 1, cat, this.formatCellValue(val, data.unit)]);
        });
      }
    }

    thead.innerHTML = `<tr>${headers.map((h) => `<th class="py-2.5 px-3">${h}</th>`).join('')}</tr>`;
    tbody.innerHTML = rows
      .map(
        (r) =>
          `<tr class="hover:bg-teal-50/40 transition">${r
            .map((c, i) => `<td class="py-2 px-3 ${i === 0 ? 'text-gray-400 font-mono text-[10px]' : i === 1 ? 'font-medium text-gray-800' : 'text-gray-600'}">${c}</td>`)
            .join('')}</tr>`
      )
      .join('');

    modal.classList.remove('hidden');
  }

  formatCellValue(val, unit) {
    if (val === null || val === undefined) return '-';
    if (Array.isArray(val)) {
      return `${this.formatCellValue(val[0], unit)} – ${this.formatCellValue(val[1], unit)}`;
    }
    if (typeof val === 'number') {
      if (unit === 'IDR' || val > 10000) return formatRupiah(val);
      if (unit === 'PERCENT' || (val <= 100 && val >= -100 && !Number.isInteger(val))) return formatPercent(val);
      return val.toLocaleString('id-ID');
    }
    return val;
  }

  setupAssistant() {
    const btnOpen = document.querySelector('#btn-floating-assistant');
    const drawer = document.querySelector('#assistant-drawer');
    const btnClose = document.querySelector('#btn-close-assistant');
    const btnSend = document.querySelector('#btn-assistant-send');
    const input = document.querySelector('#assistant-input');
    const output = document.querySelector('#assistant-chat-output');

    btnOpen?.addEventListener('click', () => drawer?.classList.remove('hidden'));
    btnClose?.addEventListener('click', () => drawer?.classList.add('hidden'));

    document.querySelectorAll('.quick-question-btn').forEach((btn) => {
      btn.addEventListener('click', () => {
        const reply = btn.dataset.reply;
        if (output && reply) {
          output.innerHTML += `
            <div class="p-3 bg-teal-50 border border-teal-100 rounded-xl text-teal-900 animate-in fade-in">
              <strong>Tanya:</strong> ${btn.textContent.trim()}<br/>
              <strong class="mt-1 block text-[#0F766E]">Jawaban Analis:</strong> ${reply}
            </div>
          `;
          output.scrollTop = output.scrollHeight;
        }
      });
    });

    const handleSend = () => {
      const q = input?.value.trim();
      if (!q || !output) return;

      output.innerHTML += `
        <div class="p-3 bg-gray-50 border border-gray-200 rounded-xl animate-in fade-in">
          <strong>Anda:</strong> ${q}<br/>
          <strong class="mt-1 block text-[#0F766E]">Asisten Analis:</strong>
          Terima kasih atas pertanyaan Anda mengenai '${q}'. Algoritma analisis telah merekonsiliasi seluruh data transaksi UMKM Sumber Urip dengan parameter musiman deret waktu.
        </div>
      `;
      input.value = '';
      output.scrollTop = output.scrollHeight;
    };

    btnSend?.addEventListener('click', handleSend);
    input?.addEventListener('keydown', (e) => {
      if (e.key === 'Enter') handleSend();
    });
  }

  setupThemeToggle() {
    const btn = document.querySelector('#btn-theme-toggle');
    btn?.addEventListener('click', () => {
      document.documentElement.classList.toggle('dark');
    });
  }

  setupKeyboardShortcuts() {
    window.addEventListener('keydown', (e) => {
      if ((e.ctrlKey || e.metaKey) && e.key.toLowerCase() === 'k') {
        e.preventDefault();
        const topInput = document.querySelector('#top-search-input');
        if (topInput) {
          topInput.focus();
        }
      }
    });
  }

  async loadFilters() {
    try {
      const res = await api.getFilters();
      const { categories, channels, regions, date_range } = res.filters;

      const catSelect = document.querySelector('#filter-category');
      const chSelect = document.querySelector('#filter-channel');
      const regSelect = document.querySelector('#filter-region');
      const fromInput = document.querySelector('#filter-date-from');
      const toInput = document.querySelector('#filter-date-to');

      const current = this.getFilters();

      if (catSelect && categories) {
        categories.forEach((c) => {
          const opt = new Option(c.name, c.id, false, current.category_id == c.id);
          catSelect.add(opt);
        });
      }
      if (chSelect && channels) {
        channels.forEach((ch) => {
          const opt = new Option(ch.name, ch.id, false, current.channel_id == ch.id);
          chSelect.add(opt);
        });
      }
      if (regSelect && regions) {
        regions.forEach((r) => {
          const opt = new Option(`${r.name} (${r.region_group})`, r.id, false, current.region_id == r.id);
          regSelect.add(opt);
        });
      }
      if (fromInput && !fromInput.value) {
        fromInput.value = current.date_from || date_range.min || '2023-01-01';
      }
      if (toInput && !toInput.value) {
        toInput.value = current.date_to || date_range.max || '2026-10-31';
      }
    } catch (e) {
      console.warn('Could not load filters:', e);
    }
  }

  async loadAllData() {
    if (this.abortController) {
      this.abortController.abort();
    }
    this.abortController = new AbortController();
    const signal = this.abortController.signal;

    const filters = this.getFilters();

    // 1. Load KPIs for all 6 sections
    this.loadAllKpis(filters, signal);

    // 2. Load Insights for all 6 sections
    this.loadAllInsights(filters, signal);

    // 3. Load All 25 Charts
    this.loadAllCharts(filters, signal);
  }

  async loadAllKpis(filters, signal) {
    const sections = ['ringkasan', 'produk', 'channel', 'pelanggan', 'operasional', 'prediksi'];
    for (const sec of sections) {
      const container = document.querySelector(`#kpi-${sec}`);
      if (!container) continue;

      api
        .getKpi(sec, filters, signal)
        .then((res) => {
          container.innerHTML = res.cards
            .map(
              (card) => `
            <div class="bg-white rounded-2xl border border-[#E8DCCB] p-4 shadow-xs flex flex-col justify-between">
              <div class="flex items-center justify-between gap-1 text-[11px] text-gray-500 font-medium">
                <span>${card.label}</span>
                <span class="px-2 py-0.5 rounded-full text-[10px] font-bold ${
                  card.trend === 'up'
                    ? 'bg-emerald-50 text-emerald-700'
                    : card.trend === 'down'
                    ? 'bg-rose-50 text-rose-700'
                    : 'bg-gray-100 text-gray-600'
                }">${card.delta}</span>
              </div>
              <div class="text-xl sm:text-2xl font-bold text-gray-900 mt-2 tracking-tight">${card.value}</div>
              <div class="text-[11px] text-gray-400 mt-1">${card.subtext}</div>
            </div>
          `
            )
            .join('');
        })
        .catch((e) => {
          if (e.name !== 'AbortError') console.error(e);
        });
    }
  }

  async loadAllInsights(filters, signal) {
    const sections = ['ringkasan', 'produk', 'channel', 'pelanggan', 'operasional', 'prediksi'];
    for (const sec of sections) {
      const container = document.querySelector(`#insight-${sec}`);
      if (!container) continue;

      api
        .getInsights(sec, filters, signal)
        .then((res) => {
          container.innerHTML = res.insights
            .map(
              (ins) => `
            <div class="flex items-start gap-2 text-xs text-gray-700">
              <span class="text-[#0F766E] flex-shrink-0 mt-0.5">●</span>
              <span>${ins.text}</span>
            </div>
          `
            )
            .join('');
        })
        .catch((e) => {
          if (e.name !== 'AbortError') console.error(e);
        });
    }
  }

  loadAllCharts(filters, signal) {
    const chartElements = document.querySelectorAll('.chart-card[data-chart-id]');
    chartElements.forEach((el) => {
      const chartId = el.dataset.chartId;
      this.renderSingleChart(chartId, el, filters, signal);
    });
  }

  async renderSingleChart(chartId, cardElement, filters, signal) {
    const bodyEl = cardElement.querySelector('.chart-body');
    if (!bodyEl) return;

    // Show skeleton
    bodyEl.innerHTML = '<div class="animate-pulse bg-gray-100 w-full h-[280px] rounded-xl flex items-center justify-center text-xs text-gray-400">Memuat visualisasi...</div>';

    try {
      const data = await api.getChart(chartId, filters, signal);
      bodyEl.innerHTML = '';

      // Save to memory for Table Modal
      this.chartDataMap.set(chartId.toLowerCase(), data);

      if (!window.ApexCharts) {
        bodyEl.innerHTML = '<div class="p-6 text-center text-xs text-gray-500">Pustaka visualisasi (ApexCharts) belum termuat.</div>';
        return;
      }

      const builder = chartRegistry[chartId.toLowerCase()];
      if (!builder) {
        bodyEl.innerHTML = '<div class="p-6 text-center text-xs text-gray-500">Konfigurasi chart belum tersedia.</div>';
        return;
      }

      if (this.activeCharts.has(chartId)) {
        this.activeCharts.get(chartId).destroy();
        this.activeCharts.delete(chartId);
      }

      const options = builder(data);
      const chart = new ApexCharts(bodyEl, options);
      await chart.render();
      this.activeCharts.set(chartId, chart);

      const subEl = cardElement.querySelector('.chart-subtitle');
      if (subEl && data.subtitle) {
        subEl.textContent = data.subtitle;
      }
    } catch (e) {
      if (e.name === 'AbortError') return;
      bodyEl.innerHTML = `
        <div class="p-6 text-center">
          <p class="text-xs text-rose-600 font-medium">Gagal memuat chart: ${e.message}</p>
          <div class="flex items-center justify-center gap-2 mt-3">
            <button class="px-3 py-1.5 rounded-lg border border-gray-300 text-xs text-gray-700 hover:bg-gray-50" onclick="window.ebonyApp.renderSingleChart('${chartId}', this.closest('.chart-card'), window.ebonyApp.getFilters())">Coba lagi</button>
            <a href="${window.location.pathname.includes('/public') ? window.location.pathname.substring(0, window.location.pathname.indexOf('/public') + 7) : ''}/setup" class="px-3 py-1.5 rounded-lg bg-[#0F766E] text-white text-xs font-semibold hover:bg-[#0D6E6E]">Inisialisasi Database Otomatis</a>
          </div>
        </div>
      `;
    }
  }
}

// Bootstrap App
document.addEventListener('DOMContentLoaded', () => {
  window.ebonyApp = new EbonyApp();
});
