// FORMATTER UTILITIES (format.js) - Locale id-ID
export const formatRupiah = (num) => {
  if (Array.isArray(num)) {
    return `${formatRupiah(num[0])} – ${formatRupiah(num[1])}`;
  }
  if (num === null || num === undefined || isNaN(num)) return 'Rp 0';
  return 'Rp ' + Math.round(Number(num)).toLocaleString('id-ID');
};

export const formatCompactRupiah = (num) => {
  if (num === null || num === undefined || isNaN(num)) return 'Rp 0';
  const val = Math.abs(Number(num));
  const sign = num < 0 ? '-' : '';

  if (val >= 1_000_000_000) {
    const d = (val / 1_000_000_000).toFixed(1).replace('.', ',');
    return `${sign}Rp ${d} M`;
  }
  if (val >= 1_000_000) {
    const d = (val / 1_000_000).toFixed(1).replace('.', ',');
    return `${sign}Rp ${d} jt`;
  }
  if (val >= 1_000) {
    return `${sign}Rp ${Math.round(val / 1_000).toLocaleString('id-ID')} rb`;
  }
  return `${sign}Rp ${Math.round(val).toLocaleString('id-ID')}`;
};

export const formatPercent = (val, decimals = 1) => {
  if (val === null || val === undefined || isNaN(val)) return '0%';
  return Number(val).toFixed(decimals).replace('.', ',') + '%';
};

const INDO_MONTHS = ['Jan', 'Feb', 'Mar', 'Apr', 'Mei', 'Jun', 'Jul', 'Agu', 'Sep', 'Okt', 'Nov', 'Des'];

export const formatMonth = (periodStr) => {
  if (!periodStr || !periodStr.includes('-')) return periodStr;
  const parts = periodStr.split('-');
  const y = parts[0];
  const m = parseInt(parts[1], 10);
  return `${INDO_MONTHS[m - 1] || m} ${y}`;
};

export const formatFullDate = (dateStr) => {
  if (!dateStr || !dateStr.includes('-')) return dateStr;
  const parts = dateStr.split('-');
  const y = parts[0];
  const m = parseInt(parts[1], 10);
  const d = parseInt(parts[2], 10);
  return `${d} ${INDO_MONTHS[m - 1] || m} ${y}`;
};
