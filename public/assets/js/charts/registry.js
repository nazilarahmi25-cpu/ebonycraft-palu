// CHART REGISTRY (registry.js) - ApexCharts Configurations for C01 through C25
// Styled with Jelajah Sulteng Palette: Deep Teal, Turquoise, Warm Amber, Coral, Navy
import { formatRupiah, formatCompactRupiah, formatPercent, formatMonth } from '../format.js';

const SULTENG_PALETTE = [
  '#0F766E', // Deep Teal (Primary)
  '#14B8A6', // Turquoise
  '#E76F51', // Coral
  '#F59E0B', // Warm Amber
  '#0284C7', // Ocean Blue
  '#8B5CF6', // Purple
  '#2A211B', // Ebony Wood Dark
  '#64748B', // Slate Gray
];

const baseOptions = {
  chart: {
    fontFamily: 'Inter, system-ui, sans-serif',
    toolbar: { show: false },
    animations: { enabled: true, speed: 450 },
  },
  colors: SULTENG_PALETTE,
  dataLabels: { enabled: false },
  stroke: { curve: 'smooth', width: 2.5 },
  grid: {
    borderColor: '#F3EFEA',
    strokeDashArray: 3,
    padding: { top: 10, right: 15, bottom: 5, left: 10 },
  },
  xaxis: {
    labels: { style: { colors: '#78716C', fontSize: '11px', fontFamily: 'Inter' } },
    axisBorder: { color: '#E8DCCB' },
    axisTicks: { color: '#E8DCCB' },
  },
  yaxis: {
    labels: {
      style: { colors: '#78716C', fontSize: '11px', fontFamily: 'Inter' },
      formatter: (val) => formatCompactRupiah(val),
    },
  },
  tooltip: {
    theme: 'light',
    style: { fontSize: '12px', fontFamily: 'Inter' },
    y: { formatter: (val) => formatRupiah(val) },
  },
};

export const chartRegistry = {
  // C01: Tren Pendapatan Bulanan (Area)
  c01(data) {
    return {
      ...baseOptions,
      chart: { ...baseOptions.chart, type: 'area', height: 320 },
      colors: ['#0F766E'],
      fill: {
        type: 'gradient',
        gradient: {
          shadeIntensity: 1,
          opacityFrom: 0.45,
          opacityTo: 0.05,
          stops: [0, 90, 100],
          colorStops: [
            { offset: 0, color: '#0F766E', opacity: 0.45 },
            { offset: 100, color: '#14B8A6', opacity: 0.02 },
          ],
        },
      },
      series: data.series,
      xaxis: {
        ...baseOptions.xaxis,
        categories: data.categories.map(formatMonth),
      },
    };
  },

  // C02: Perbandingan Tahunan per Bulan (Grouped Column)
  c02(data) {
    return {
      ...baseOptions,
      chart: { ...baseOptions.chart, type: 'bar', height: 320 },
      colors: ['#DED1BF', '#94D2BD', '#0F766E', '#E76F51'],
      plotOptions: { bar: { horizontal: false, columnWidth: '60%', borderRadius: 3 } },
      series: data.series,
      xaxis: { ...baseOptions.xaxis, categories: data.categories },
      legend: { position: 'top', horizontalAlign: 'right', fontSize: '11px' },
    };
  },

  // C03: Pendapatan vs Laba Kotor (Combo: Column + Line Margin %)
  c03(data) {
    return {
      ...baseOptions,
      chart: { ...baseOptions.chart, type: 'line', height: 320 },
      colors: ['#0F766E', '#14B8A6', '#F59E0B'],
      stroke: { width: [0, 0, 3], curve: 'smooth' },
      series: data.series,
      xaxis: { ...baseOptions.xaxis, categories: data.categories.map(formatMonth) },
      yaxis: [
        {
          labels: { formatter: (v) => formatCompactRupiah(v), style: { colors: '#78716C' } },
        },
        {
          opposite: true,
          labels: { formatter: (v) => formatPercent(v), style: { colors: '#F59E0B' } },
        },
      ],
      tooltip: {
        shared: true,
        intersect: false,
        y: {
          formatter: (v, { seriesIndex }) => (seriesIndex === 2 ? formatPercent(v) : formatRupiah(v)),
        },
      },
    };
  },

  // C04: Heatmap Musiman
  c04(data) {
    return {
      ...baseOptions,
      chart: { ...baseOptions.chart, type: 'heatmap', height: 320 },
      dataLabels: { enabled: true, style: { colors: ['#1C1410'], fontSize: '10px', fontWeight: '500' } },
      colors: ['#0F766E'],
      plotOptions: {
        heatmap: {
          radius: 4,
          enableShades: true,
          colorScale: {
            ranges: [
              { from: 0, to: 15, color: '#E0F2F1', name: 'Rendah (<15 Jt)' },
              { from: 15.1, to: 28, color: '#80CBC4', name: 'Sedang (15-28 Jt)' },
              { from: 28.1, to: 50, color: '#0F766E', name: 'Tinggi (>28 Jt)' },
            ],
          },
        },
      },
      series: data.series,
      tooltip: {
        y: { formatter: (val) => `${val} Juta Rp` },
      },
    };
  },

  // C05: Penjualan per Hari dalam Seminggu (Column Bar)
  c05(data) {
    return {
      ...baseOptions,
      chart: { ...baseOptions.chart, type: 'bar', height: 320 },
      colors: ['#0F766E', '#0F766E', '#0F766E', '#0F766E', '#0F766E', '#E76F51', '#E76F51'],
      plotOptions: { bar: { columnWidth: '48%', borderRadius: 5, distributed: true } },
      series: data.series,
      xaxis: { ...baseOptions.xaxis, categories: data.categories },
      legend: { show: false },
    };
  },

  // C06: Top 10 Produk (Horizontal Bar)
  c06(data) {
    return {
      ...baseOptions,
      chart: { ...baseOptions.chart, type: 'bar', height: 320 },
      plotOptions: { bar: { horizontal: true, barHeight: '65%', borderRadius: 4 } },
      colors: ['#0F766E'],
      series: data.series,
      xaxis: {
        ...baseOptions.xaxis,
        categories: data.categories,
        labels: { formatter: (v) => formatCompactRupiah(v) },
      },
      yaxis: { labels: { style: { colors: '#1C1410', fontSize: '11px', fontWeight: '500' } } },
    };
  },

  // C07: Komposisi per Kategori (Donut)
  c07(data) {
    return {
      ...baseOptions,
      chart: { ...baseOptions.chart, type: 'donut', height: 320 },
      colors: ['#0F766E', '#14B8A6', '#E76F51', '#F59E0B', '#0284C7'],
      labels: data.categories,
      series: data.series,
      legend: { position: 'bottom', fontSize: '11px' },
      tooltip: { y: { formatter: (v) => formatRupiah(v) } },
    };
  },

  // C08: Analisis Pareto 80/20
  c08(data) {
    return {
      ...baseOptions,
      chart: { ...baseOptions.chart, type: 'line', height: 320 },
      colors: ['#0F766E', '#E76F51'],
      stroke: { width: [0, 3], curve: 'straight' },
      series: data.series,
      xaxis: { ...baseOptions.xaxis, categories: data.categories },
      yaxis: [
        { labels: { formatter: (v) => formatCompactRupiah(v) } },
        { opposite: true, max: 100, labels: { formatter: (v) => `${v}%` } },
      ],
      annotations: {
        yaxis: [
          {
            y: 80,
            yAxisIndex: 1,
            borderColor: '#E76F51',
            strokeDashArray: 4,
            label: { text: 'Batas 80% Pareto', style: { color: '#E76F51', background: '#FFF' } },
          },
        ],
      },
      legend: { position: 'top', horizontalAlign: 'right', fontSize: '11px' },
    };
  },

  // C09: Bubble Harga vs Volume vs Margin
  c09(data) {
    return {
      ...baseOptions,
      chart: { ...baseOptions.chart, type: 'bubble', height: 320 },
      colors: ['#0F766E', '#14B8A6', '#E76F51', '#F59E0B', '#0284C7'],
      series: data.series,
      xaxis: {
        ...baseOptions.xaxis,
        title: { text: 'Harga Jual (Rp)', style: { fontSize: '11px', color: '#78716C' } },
        labels: { formatter: (v) => formatCompactRupiah(v) },
      },
      yaxis: {
        title: { text: 'Unit Terjual', style: { fontSize: '11px', color: '#78716C' } },
        labels: { formatter: (v) => `${v} unit` },
      },
      tooltip: {
        custom: ({ series, seriesIndex, dataPointIndex, w }) => {
          const pt = w.config.series[seriesIndex].data[dataPointIndex];
          return `
            <div style="padding: 10px; font-size: 11px; line-height: 1.5;">
              <strong style="color: #0F766E;">${pt.name}</strong><br/>
              Kategori: ${w.config.series[seriesIndex].name}<br/>
              Harga: <strong>${formatRupiah(pt.x)}</strong><br/>
              Volume: <strong>${pt.y} unit</strong><br/>
              Margin Kotor: <strong>${pt.z}%</strong>
            </div>
          `;
        },
      },
    };
  },

  // C10: Tren Pendapatan per Kategori (Stacked Area)
  c10(data) {
    return {
      ...baseOptions,
      chart: { ...baseOptions.chart, type: 'area', stacked: true, height: 340 },
      colors: ['#0F766E', '#14B8A6', '#E76F51', '#F59E0B', '#0284C7'],
      series: data.series,
      xaxis: { ...baseOptions.xaxis, categories: data.categories.map(formatMonth) },
      legend: { position: 'top', horizontalAlign: 'left', fontSize: '11px' },
    };
  },

  // C11: Pendapatan per Channel (Column)
  c11(data) {
    return {
      ...baseOptions,
      chart: { ...baseOptions.chart, type: 'bar', height: 320 },
      colors: ['#0F766E'],
      plotOptions: { bar: { columnWidth: '45%', borderRadius: 5 } },
      series: data.series,
      xaxis: { ...baseOptions.xaxis, categories: data.categories },
    };
  },

  // C12: Pergeseran Porsi Channel (100% Stacked Bar)
  c12(data) {
    return {
      ...baseOptions,
      chart: { ...baseOptions.chart, type: 'bar', stacked: true, stackType: '100%', height: 320 },
      colors: ['#0F766E', '#14B8A6', '#E76F51', '#F59E0B', '#0284C7', '#64748B'],
      series: data.series,
      xaxis: { ...baseOptions.xaxis, categories: data.categories },
      yaxis: { labels: { formatter: (v) => `${v}%` } },
      legend: { position: 'top', horizontalAlign: 'right', fontSize: '11px' },
    };
  },

  // C13: Treemap Wilayah
  c13(data) {
    return {
      ...baseOptions,
      chart: { ...baseOptions.chart, type: 'treemap', height: 320 },
      colors: ['#0F766E', '#14B8A6', '#E76F51', '#F59E0B', '#0284C7'],
      series: data.series,
      legend: { show: false },
      tooltip: { y: { formatter: (v) => formatRupiah(v) } },
    };
  },

  // C14: Segmen Pembeli (Pie)
  c14(data) {
    return {
      ...baseOptions,
      chart: { ...baseOptions.chart, type: 'pie', height: 320 },
      colors: ['#0F766E', '#14B8A6', '#E76F51', '#F59E0B', '#0284C7'],
      labels: data.categories,
      series: data.series,
      legend: { position: 'bottom', fontSize: '11px' },
      tooltip: { y: { formatter: (v) => formatRupiah(v) } },
    };
  },

  // C15: Pelanggan Baru vs Ulang (Stacked Column)
  c15(data) {
    return {
      ...baseOptions,
      chart: { ...baseOptions.chart, type: 'bar', stacked: true, height: 320 },
      colors: ['#0F766E', '#E76F51'],
      series: data.series,
      xaxis: { ...baseOptions.xaxis, categories: data.categories.map(formatMonth) },
      yaxis: { labels: { formatter: (v) => `${v} order` } },
      legend: { position: 'top', horizontalAlign: 'right', fontSize: '11px' },
    };
  },

  // C16: Distribusi Nilai Transaksi (Histogram)
  c16(data) {
    return {
      ...baseOptions,
      chart: { ...baseOptions.chart, type: 'bar', height: 320 },
      colors: ['#0F766E'],
      plotOptions: { bar: { columnWidth: '85%', borderRadius: 4 } },
      series: data.series,
      xaxis: { ...baseOptions.xaxis, categories: data.categories },
      yaxis: { labels: { formatter: (v) => `${v} invoice` } },
    };
  },

  // C17: Metode Pembayaran (Radial Bar)
  c17(data) {
    return {
      ...baseOptions,
      chart: { ...baseOptions.chart, type: 'radialBar', height: 320 },
      colors: ['#0F766E', '#14B8A6', '#E76F51', '#F59E0B', '#0284C7'],
      labels: data.categories,
      series: data.series,
      legend: { show: true, position: 'bottom', fontSize: '11px' },
    };
  },

  // C18: Tren AOV (Line)
  c18(data) {
    return {
      ...baseOptions,
      chart: { ...baseOptions.chart, type: 'line', height: 320 },
      colors: ['#0F766E'],
      stroke: { width: 3 },
      series: data.series,
      xaxis: { ...baseOptions.xaxis, categories: data.categories.map(formatMonth) },
    };
  },

  // C19: Stok Akhir vs Terjual (Combo)
  c19(data) {
    return {
      ...baseOptions,
      chart: { ...baseOptions.chart, type: 'line', height: 340 },
      colors: ['#CCFBEF', '#0F766E'],
      stroke: { width: [1, 0] },
      fill: { opacity: [0.4, 1] },
      series: data.series,
      xaxis: { ...baseOptions.xaxis, categories: data.categories.map(formatMonth) },
      yaxis: { labels: { formatter: (v) => `${v} unit` } },
      tooltip: { y: { formatter: (v) => `${v} unit` } },
      legend: { position: 'top', horizontalAlign: 'right', fontSize: '11px' },
    };
  },

  // C20: Struktur Biaya per Tahun (100% Horizontal Stacked Bar)
  c20(data) {
    return {
      ...baseOptions,
      chart: { ...baseOptions.chart, type: 'bar', stacked: true, stackType: '100%', height: 320 },
      colors: ['#0F766E', '#14B8A6', '#F59E0B', '#E76F51'],
      plotOptions: { bar: { horizontal: true, barHeight: '55%', borderRadius: 3 } },
      series: data.series,
      xaxis: { ...baseOptions.xaxis, categories: data.categories, labels: { formatter: (v) => `${v}%` } },
      legend: { position: 'top', fontSize: '11px' },
      tooltip: { y: { formatter: (v) => formatRupiah(v) } },
    };
  },

  // C21: Lead Time Boxplot
  c21(data) {
    return {
      ...baseOptions,
      chart: { ...baseOptions.chart, type: 'boxPlot', height: 320 },
      colors: ['#0F766E', '#E76F51'],
      series: data.series,
      yaxis: { labels: { formatter: (v) => `${v} hari` } },
    };
  },

  // C22: Prediksi 12 Bulan + Interval 95%
  c22(data) {
    let actualData = [];
    let forecastData = [];
    let upperData = [];
    let lowerData = [];

    const sActual = data.series?.find((s) => s.name?.includes('Aktual'));
    const sForecast = data.series?.find((s) => s.name?.includes('Proyeksi') || s.name?.includes('Prediksi'));
    const sUpper = data.series?.find((s) => s.name?.includes('Batas Atas'));
    const sLower = data.series?.find((s) => s.name?.includes('Batas Bawah'));
    const sRange = data.series?.find((s) => s.type === 'rangeArea' || s.name?.includes('Interval'));

    actualData = sActual?.data || [];
    forecastData = sForecast?.data || [];

    if (sUpper && sLower) {
      upperData = sUpper.data || [];
      lowerData = sLower.data || [];
    } else if (sRange && Array.isArray(sRange.data)) {
      upperData = sRange.data.map((item) => (Array.isArray(item) ? Math.round(Number(item[1])) : item?.y ? Math.round(Number(item.y[1])) : null));
      lowerData = sRange.data.map((item) => (Array.isArray(item) ? Math.round(Number(item[0])) : item?.y ? Math.round(Number(item.y[0])) : null));
    }

    const series = [
      { name: 'Aktual Terakhir', data: actualData },
      { name: 'Prediksi Holt-Winters', data: forecastData },
      { name: 'Batas Atas (95%)', data: upperData },
      { name: 'Batas Bawah (95%)', data: lowerData },
    ];

    return {
      ...baseOptions,
      chart: { ...baseOptions.chart, type: 'line', height: 350 },
      colors: ['#0F766E', '#E76F51', '#0284C7', '#0284C7'],
      stroke: {
        curve: 'smooth',
        width: [3, 3, 1.8, 1.8],
        dashArray: [0, 0, 5, 5],
      },
      series,
      xaxis: {
        ...baseOptions.xaxis,
        categories: (data.categories || []).map(formatMonth),
      },
      legend: { position: 'top', horizontalAlign: 'right', fontSize: '11px' },
      tooltip: {
        ...baseOptions.tooltip,
        y: {
          formatter: (val) => formatRupiah(val),
        },
      },
    };
  },

  // C23: Backtest Aktual vs 3 Model
  c23(data) {
    return {
      ...baseOptions,
      chart: { ...baseOptions.chart, type: 'line', height: 320 },
      colors: ['#1C1410', '#0F766E', '#0284C7', '#F59E0B'],
      stroke: { width: [3, 2.5, 2, 2], dashArray: [0, 3, 3, 3] },
      series: data.series,
      xaxis: { ...baseOptions.xaxis, categories: data.categories.map(formatMonth) },
      legend: { position: 'top', horizontalAlign: 'right', fontSize: '11px' },
    };
  },

  // C24: Akurasi Model (Grouped Bar)
  c24(data) {
    return {
      ...baseOptions,
      chart: { ...baseOptions.chart, type: 'bar', height: 320 },
      colors: ['#0F766E', '#E76F51'],
      plotOptions: { bar: { columnWidth: '45%', borderRadius: 4 } },
      series: data.series,
      xaxis: { ...baseOptions.xaxis, categories: data.categories },
      yaxis: { labels: { formatter: (v) => `${v}%` } },
      legend: { position: 'top', horizontalAlign: 'right', fontSize: '11px' },
    };
  },

  // C25: Prediksi per Kategori (Stacked Column)
  c25(data) {
    return {
      ...baseOptions,
      chart: { ...baseOptions.chart, type: 'bar', stacked: true, height: 340 },
      colors: ['#0F766E', '#14B8A6', '#E76F51', '#F59E0B', '#0284C7'],
      series: data.series,
      xaxis: { ...baseOptions.xaxis, categories: data.categories.map(formatMonth) },
      legend: { position: 'top', horizontalAlign: 'left', fontSize: '11px' },
    };
  },
};
