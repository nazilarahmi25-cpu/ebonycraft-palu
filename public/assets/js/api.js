// API WRAPPER (api.js)
const getBaseUrl = () => {
  // Respect subfolder deployment
  const loc = window.location.pathname;
  if (loc.includes('/public')) {
    return loc.substring(0, loc.indexOf('/public') + 7);
  }
  return '';
};

const BASE_URL = getBaseUrl();

const buildQuery = (params = {}) => {
  const q = new URLSearchParams();
  for (const [k, v] of Object.entries(params)) {
    if (v !== null && v !== undefined && v !== '') {
      q.set(k, v);
    }
  }
  const s = q.toString();
  return s ? `?${s}` : '';
};

export const api = {
  async getChart(chartId, filters = {}, signal = null) {
    const url = `${BASE_URL}/api/v1/charts/${chartId}${buildQuery(filters)}`;
    const res = await fetch(url, { signal });
    if (!res.ok) {
      const err = await res.json().catch(() => ({}));
      throw new Error(err.error?.message || `Gagal memuat chart ${chartId}`);
    }
    return await res.json();
  },

  async getKpi(page, filters = {}, signal = null) {
    const params = { page, ...filters };
    const url = `${BASE_URL}/api/v1/kpi${buildQuery(params)}`;
    const res = await fetch(url, { signal });
    if (!res.ok) throw new Error('Gagal memuat kartu KPI');
    return await res.json();
  },

  async getInsights(page, filters = {}, signal = null) {
    const params = { page, ...filters };
    const url = `${BASE_URL}/api/v1/insights${buildQuery(params)}`;
    const res = await fetch(url, { signal });
    if (!res.ok) throw new Error('Gagal memuat insight');
    return await res.json();
  },

  async getFilters(signal = null) {
    const url = `${BASE_URL}/api/v1/filters`;
    const res = await fetch(url, { signal });
    if (!res.ok) throw new Error('Gagal memuat opsi filter');
    return await res.json();
  },

  async getForecastSummary(signal = null) {
    const url = `${BASE_URL}/api/v1/forecast/summary`;
    const res = await fetch(url, { signal });
    if (!res.ok) throw new Error('Gagal memuat ringkasan prediksi');
    return await res.json();
  },

  async runForecast(csrfToken) {
    const url = `${BASE_URL}/api/v1/forecast/run`;
    const res = await fetch(url, {
      method: 'POST',
      headers: { 'Content-Type': 'application/json' },
      body: JSON.stringify({ csrf_token: csrfToken }),
    });
    if (!res.ok) {
      const err = await res.json().catch(() => ({}));
      throw new Error(err.error?.message || 'Gagal menghitung ulang prediksi');
    }
    return await res.json();
  },

  async clearCache(csrfToken) {
    const url = `${BASE_URL}/api/v1/cache/clear`;
    const res = await fetch(url, {
      method: 'POST',
      headers: { 'Content-Type': 'application/json' },
      body: JSON.stringify({ csrf_token: csrfToken }),
    });
    if (!res.ok) {
      const err = await res.json().catch(() => ({}));
      throw new Error(err.error?.message || 'Gagal membersihkan cache');
    }
    return await res.json();
  }
};
