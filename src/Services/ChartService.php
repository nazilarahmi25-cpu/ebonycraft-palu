<?php
declare(strict_types=1);

namespace App\Services;

use App\Core\Cache;
use App\Repositories\SalesRepository;
use App\Repositories\ProductRepository;
use App\Repositories\OperationsRepository;
use App\Repositories\ForecastRepository;
use App\Support\Stats;

class ChartService
{
    private SalesRepository $salesRepo;
    private ProductRepository $productRepo;
    private OperationsRepository $opsRepo;
    private ForecastRepository $forecastRepo;

    public function __construct(
        ?SalesRepository $salesRepo = null,
        ?ProductRepository $productRepo = null,
        ?OperationsRepository $opsRepo = null,
        ?ForecastRepository $forecastRepo = null
    ) {
        $this->salesRepo    = $salesRepo ?? new SalesRepository();
        $this->productRepo  = $productRepo ?? new ProductRepository();
        $this->opsRepo      = $opsRepo ?? new OperationsRepository();
        $this->forecastRepo = $forecastRepo ?? new ForecastRepository();
    }

    public function getChartData(string $chartId, array $filters = []): array
    {
        $chartId = strtolower($chartId);
        $cached = Cache::get($chartId, $filters);
        if ($cached !== null) {
            $cached['meta']['cached'] = true;
            return $cached;
        }

        $method = 'build' . strtoupper($chartId);
        if (!method_exists($this, $method)) {
            throw new \InvalidArgumentException("Chart {$chartId} is not supported.");
        }

        $chart = $this->$method($filters);
        $chart['meta'] = [
            'filters'      => $filters,
            'generated_at' => date('c'),
            'cached'       => false,
        ];

        Cache::set($chartId, $chart, $filters);
        return $chart;
    }

    // C01: Tren Pendapatan Bulanan (Area)
    private function buildC01(array $filters): array
    {
        $rows = $this->salesRepo->getMonthlyRevenue($filters);
        $categories = array_column($rows, 'period');
        $data = array_map(fn($r) => (float)$r['revenue'], $rows);

        return [
            'chart_id'   => 'c01',
            'title'      => 'Tren Pendapatan Bulanan',
            'subtitle'   => 'Bagaimana arah pendapatan usaha dari waktu ke waktu?',
            'type'       => 'area',
            'unit'       => 'IDR',
            'categories' => $categories,
            'series'     => [
                ['name' => 'Pendapatan Bersih', 'data' => $data]
            ],
            'extra'      => [],
        ];
    }

    // C02: Perbandingan Tahunan per Bulan (Grouped Column)
    private function buildC02(array $filters): array
    {
        $rows = $this->salesRepo->getYearOverYear($filters);
        $months = ['Jan', 'Feb', 'Mar', 'Apr', 'Mei', 'Jun', 'Jul', 'Agu', 'Sep', 'Okt', 'Nov', 'Des'];
        
        $yearsData = [];
        foreach ($rows as $r) {
            $yr = (int)$r['order_year'];
            $mo = (int)$r['order_month'] - 1;
            if (!isset($yearsData[$yr])) {
                $yearsData[$yr] = array_fill(0, 12, 0);
            }
            $yearsData[$yr][$mo] = (float)$r['revenue'];
        }

        $series = [];
        foreach ($yearsData as $yr => $data) {
            $series[] = ['name' => (string)$yr, 'data' => $data];
        }

        return [
            'chart_id'   => 'c02',
            'title'      => 'Perbandingan Pendapatan Tahunan per Bulan',
            'subtitle'   => 'Bulan apa yang naik/turun dibanding tahun sebelumnya (YoY)?',
            'type'       => 'bar',
            'unit'       => 'IDR',
            'categories' => $months,
            'series'     => $series,
            'extra'      => [],
        ];
    }

    // C03: Pendapatan vs Laba Kotor (Combo: Column + Line Margin %)
    private function buildC03(array $filters): array
    {
        $rows = $this->salesRepo->getRevenueAndProfit($filters);
        $categories = [];
        $revenue = [];
        $grossProfit = [];
        $marginPct = [];

        foreach ($rows as $r) {
            $categories[] = $r['period'];
            $rev = (float)$r['revenue'];
            $hpp = (float)$r['hpp'];
            $profit = $rev - $hpp;
            $revenue[] = $rev;
            $grossProfit[] = $profit;
            $marginPct[] = $rev > 0 ? round(($profit / $rev) * 100, 1) : 0.0;
        }

        return [
            'chart_id'   => 'c03',
            'title'      => 'Pendapatan vs Laba Kotor & Margin %',
            'subtitle'   => 'Seberapa sehat margin keuntungan usaha?',
            'type'       => 'combo',
            'unit'       => 'IDR',
            'categories' => $categories,
            'series'     => [
                ['name' => 'Pendapatan', 'type' => 'column', 'data' => $revenue],
                ['name' => 'Laba Kotor', 'type' => 'column', 'data' => $grossProfit],
                ['name' => 'Margin Kotor (%)', 'type' => 'line', 'data' => $marginPct],
            ],
            'extra'      => [],
        ];
    }

    // C04: Heatmap Musiman (Heatmap)
    private function buildC04(array $filters): array
    {
        $rows = $this->salesRepo->getSeasonalHeatmap($filters);
        $months = ['Jan', 'Feb', 'Mar', 'Apr', 'Mei', 'Jun', 'Jul', 'Agu', 'Sep', 'Okt', 'Nov', 'Des'];

        $yearMap = [];
        foreach ($rows as $r) {
            $yr = (string)$r['order_year'];
            $mo = (int)$r['order_month'] - 1;
            if (!isset($yearMap[$yr])) {
                $yearMap[$yr] = array_fill(0, 12, 0);
            }
            $yearMap[$yr][$mo] = round((float)$r['revenue'] / 1_000_000, 1); // in Million IDR
        }

        $series = [];
        foreach ($yearMap as $yr => $moValues) {
            $dataPoints = [];
            foreach ($moValues as $idx => $val) {
                $dataPoints[] = ['x' => $months[$idx], 'y' => $val];
            }
            $series[] = ['name' => $yr, 'data' => $dataPoints];
        }

        return [
            'chart_id'   => 'c04',
            'title'      => 'Heatmap Musiman (Bulan × Tahun)',
            'subtitle'   => 'Kapan musim ramai dan sepi secara konsisten? (Juta Rp)',
            'type'       => 'heatmap',
            'unit'       => 'Juta IDR',
            'categories' => $months,
            'series'     => $series,
            'extra'      => [],
        ];
    }

    // C05: Penjualan per Hari dalam Seminggu (Column)
    private function buildC05(array $filters): array
    {
        $rows = $this->salesRepo->getSalesByDayOfWeek($filters);
        // DAYOFWEEK: 1=Minggu, 2=Senin, 3=Selasa, 4=Rabu, 5=Kamis, 6=Jumat, 7=Sabtu
        $dayNames = [
            1 => 'Minggu', 2 => 'Senin', 3 => 'Selasa', 4 => 'Rabu',
            5 => 'Kamis', 6 => 'Jumat', 7 => 'Sabtu'
        ];

        $categories = array_values($dayNames);
        $dataMap = array_fill(1, 7, 0.0);
        foreach ($rows as $r) {
            $d = (int)$r['day_num'];
            $dataMap[$d] = (float)$r['revenue'];
        }

        return [
            'chart_id'   => 'c05',
            'title'      => 'Penjualan per Hari dalam Seminggu',
            'subtitle'   => 'Hari apa pembeli paling banyak untuk jadwal promosi dan stok?',
            'type'       => 'bar',
            'unit'       => 'IDR',
            'categories' => $categories,
            'series'     => [
                ['name' => 'Pendapatan Rata-rata', 'data' => array_values($dataMap)]
            ],
            'extra'      => [],
        ];
    }

    // C06: Top 10 Produk Terlaris (Horizontal Bar)
    private function buildC06(array $filters): array
    {
        $rows = $this->productRepo->getTopProducts(10, $filters);
        $categories = array_column($rows, 'product_name');
        $data = array_map(fn($r) => (float)$r['revenue'], $rows);

        return [
            'chart_id'   => 'c06',
            'title'      => 'Top 10 Produk Terlaris',
            'subtitle'   => 'Produk mana penyumbang pendapatan terbesar?',
            'type'       => 'horizontalBar',
            'unit'       => 'IDR',
            'categories' => $categories,
            'series'     => [
                ['name' => 'Pendapatan', 'data' => $data]
            ],
            'extra'      => [],
        ];
    }

    // C07: Komposisi Pendapatan per Kategori (Donut)
    private function buildC07(array $filters): array
    {
        $rows = $this->productRepo->getRevenueByCategory($filters);
        $labels = array_column($rows, 'category_name');
        $series = array_map(fn($r) => (float)$r['revenue'], $rows);

        return [
            'chart_id'   => 'c07',
            'title'      => 'Komposisi Pendapatan per Kategori',
            'subtitle'   => 'Kategori mana yang mendominasi penjualan?',
            'type'       => 'donut',
            'unit'       => 'IDR',
            'categories' => $labels,
            'series'     => $series,
            'extra'      => [],
        ];
    }

    // C08: Analisis Pareto 80/20 (Column + Cumulative Line)
    private function buildC08(array $filters): array
    {
        $rows = $this->productRepo->getParetoData($filters);
        $categories = array_column($rows, 'product_name');
        $revData = array_map(fn($r) => (float)$r['revenue'], $rows);
        $cumData = array_column($rows, 'cum_pct');

        return [
            'chart_id'   => 'c08',
            'title'      => 'Analisis Pareto 80/20 Produk',
            'subtitle'   => 'Berapa persen produk yang menghasilkan 80% pendapatan?',
            'type'       => 'pareto',
            'unit'       => 'IDR',
            'categories' => $categories,
            'series'     => [
                ['name' => 'Pendapatan', 'type' => 'column', 'data' => $revData],
                ['name' => 'Kumulatif %', 'type' => 'line', 'data' => $cumData],
            ],
            'extra'      => ['pareto_threshold' => 80],
        ];
    }

    // C09: Harga vs Volume vs Margin (Bubble)
    private function buildC09(array $filters): array
    {
        $rows = $this->productRepo->getPriceVolumeMargin($filters);
        $grouped = [];
        foreach ($rows as $r) {
            $cat = $r['category_name'];
            $grouped[$cat][] = [
                'x' => (int)$r['price'],
                'y' => (int)$r['units_sold'],
                'z' => (float)$r['margin_pct'], // bubble size
                'name' => $r['product_name']
            ];
        }

        $series = [];
        foreach ($grouped as $catName => $points) {
            $series[] = ['name' => $catName, 'data' => $points];
        }

        return [
            'chart_id'   => 'c09',
            'title'      => 'Harga vs Volume vs Margin Produk',
            'subtitle'   => 'Produk mana yang volume tinggi dan margin tinggi (bintang) vs rendah (evaluasi)?',
            'type'       => 'bubble',
            'unit'       => 'Mix',
            'categories' => [],
            'series'     => $series,
            'extra'      => [],
        ];
    }

    // C10: Tren Pendapatan per Kategori (Stacked Area)
    private function buildC10(array $filters): array
    {
        $rows = $this->productRepo->getCategoryTrend($filters);
        $periods = array_values(array_unique(array_column($rows, 'period')));
        sort($periods);

        $catNames = array_values(array_unique(array_column($rows, 'category_name')));
        $catData = [];
        foreach ($catNames as $c) {
            $catData[$c] = array_fill_keys($periods, 0.0);
        }

        foreach ($rows as $r) {
            $catData[$r['category_name']][$r['period']] = (float)$r['revenue'];
        }

        $series = [];
        foreach ($catData as $cName => $pValues) {
            $series[] = ['name' => $cName, 'data' => array_values($pValues)];
        }

        return [
            'chart_id'   => 'c10',
            'title'      => 'Tren Pendapatan per Kategori',
            'subtitle'   => 'Kategori mana yang tumbuh atau menurun dari waktu ke waktu?',
            'type'       => 'stackedArea',
            'unit'       => 'IDR',
            'categories' => $periods,
            'series'     => $series,
            'extra'      => [],
        ];
    }

    // C11: Pendapatan per Channel (Column)
    private function buildC11(array $filters): array
    {
        $rows = $this->salesRepo->getRevenueByChannel($filters);
        $categories = array_column($rows, 'channel_name');
        $data = array_map(fn($r) => (float)$r['revenue'], $rows);

        return [
            'chart_id'   => 'c11',
            'title'      => 'Pendapatan per Channel Penjualan',
            'subtitle'   => 'Channel penjualan mana yang paling produktif?',
            'type'       => 'bar',
            'unit'       => 'IDR',
            'categories' => $categories,
            'series'     => [
                ['name' => 'Pendapatan', 'data' => $data]
            ],
            'extra'      => [],
        ];
    }

    // C12: Pergeseran Porsi Channel per Tahun (100% Stacked Bar)
    private function buildC12(array $filters): array
    {
        $rows = $this->salesRepo->getChannelShiftPerYear($filters);
        $years = array_values(array_unique(array_column($rows, 'order_year')));
        $channels = array_values(array_unique(array_column($rows, 'channel_name')));

        $matrix = [];
        foreach ($channels as $ch) {
            $matrix[$ch] = array_fill_keys($years, 0.0);
        }

        foreach ($rows as $r) {
            $matrix[$r['channel_name']][$r['order_year']] = (float)$r['revenue'];
        }

        $series = [];
        foreach ($matrix as $chName => $yrValues) {
            $series[] = ['name' => $chName, 'data' => array_values($yrValues)];
        }

        return [
            'chart_id'   => 'c12',
            'title'      => 'Pergeseran Porsi Channel per Tahun',
            'subtitle'   => 'Apakah penjualan bergeser dari toko fisik ke kanal online?',
            'type'       => 'stacked100Bar',
            'unit'       => '%',
            'categories' => array_map(fn($y) => (string)$y, $years),
            'series'     => $series,
            'extra'      => [],
        ];
    }

    // C13: Pendapatan per Wilayah (Treemap)
    private function buildC13(array $filters): array
    {
        $rows = $this->salesRepo->getRevenueByRegion($filters);
        $points = [];
        foreach ($rows as $r) {
            $points[] = [
                'x' => $r['region_name'] . ' (' . $r['region_group'] . ')',
                'y' => (float)$r['revenue']
            ];
        }

        return [
            'chart_id'   => 'c13',
            'title'      => 'Pendapatan per Wilayah Pembeli',
            'subtitle'   => 'Dari mana pembeli berasal (Palu, kabupaten Sulteng, atau luar daerah)?',
            'type'       => 'treemap',
            'unit'       => 'IDR',
            'categories' => [],
            'series'     => [
                ['data' => $points]
            ],
            'extra'      => [],
        ];
    }

    // C14: Segmen Pembeli (Pie)
    private function buildC14(array $filters): array
    {
        $rows = $this->salesRepo->getRevenueBySegment($filters);
        $labels = array_column($rows, 'segment');
        $series = array_map(fn($r) => (float)$r['revenue'], $rows);

        return [
            'chart_id'   => 'c14',
            'title'      => 'Distribusi Segmen Pembeli',
            'subtitle'   => 'Siapa target pembeli utama: wisatawan, warga lokal, instansi, atau reseller?',
            'type'       => 'pie',
            'unit'       => 'IDR',
            'categories' => $labels,
            'series'     => $series,
            'extra'      => [],
        ];
    }

    // C15: Pelanggan Baru vs Pelanggan Ulang (Stacked Column)
    private function buildC15(array $filters): array
    {
        $rows = $this->salesRepo->getNewVsRepeatCustomers($filters);
        $categories = array_column($rows, 'period');
        $newData = array_map(fn($r) => (int)$r['new_orders'], $rows);
        $repeatData = array_map(fn($r) => (int)$r['repeat_orders'], $rows);

        return [
            'chart_id'   => 'c15',
            'title'      => 'Pesanan Pelanggan Baru vs Ulang',
            'subtitle'   => 'Apakah loyalitas pelanggan meningkat dari bulan ke bulan?',
            'type'       => 'stackedColumn',
            'unit'       => 'Pesanan',
            'categories' => $categories,
            'series'     => [
                ['name' => 'Pelanggan Baru', 'data' => $newData],
                ['name' => 'Pelanggan Ulang', 'data' => $repeatData],
            ],
            'extra'      => [],
        ];
    }

    // C16: Distribusi Nilai Transaksi (Histogram)
    private function buildC16(array $filters): array
    {
        $orderValues = $this->salesRepo->getOrderValues($filters);
        $hist = Stats::histogram($orderValues, 100_000, 1_000_000);

        return [
            'chart_id'   => 'c16',
            'title'      => 'Distribusi Nilai Transaksi Belanja',
            'subtitle'   => 'Rentang nilai belanja mana yang paling sering terjadi?',
            'type'       => 'bar',
            'unit'       => 'Frekuensi',
            'categories' => $hist['categories'],
            'series'     => [
                ['name' => 'Jumlah Transaksi', 'data' => $hist['data']]
            ],
            'extra'      => [],
        ];
    }

    // C17: Metode Pembayaran (Radial Bar)
    private function buildC17(array $filters): array
    {
        $rows = $this->salesRepo->getPaymentMethods($filters);
        $totalOrders = array_sum(array_column($rows, 'order_count'));
        $labels = [];
        $percentages = [];

        foreach ($rows as $r) {
            $labels[] = $r['payment_method'];
            $pct = $totalOrders > 0 ? round(((int)$r['order_count'] / $totalOrders) * 100, 1) : 0.0;
            $percentages[] = $pct;
        }

        return [
            'chart_id'   => 'c17',
            'title'      => 'Metode Pembayaran',
            'subtitle'   => 'Metode pembayaran apa yang paling dominan?',
            'type'       => 'radialBar',
            'unit'       => '%',
            'categories' => $labels,
            'series'     => $percentages,
            'extra'      => [],
        ];
    }

    // C18: Tren Rata-rata Nilai Order (AOV)
    private function buildC18(array $filters): array
    {
        $rows = $this->salesRepo->getMonthlyAov($filters);
        $categories = [];
        $aovData = [];

        foreach ($rows as $r) {
            $categories[] = $r['period'];
            $cnt = (int)$r['order_count'];
            $rev = (float)$r['revenue'];
            $aovData[] = $cnt > 0 ? round($rev / $cnt, 0) : 0;
        }

        return [
            'chart_id'   => 'c18',
            'title'      => 'Tren Rata-rata Nilai Pesanan (AOV)',
            'subtitle'   => 'Apakah nilai belanja per transaksi mengalami peningkatan?',
            'type'       => 'line',
            'unit'       => 'IDR',
            'categories' => $categories,
            'series'     => [
                ['name' => 'Rata-rata Order (AOV)', 'data' => $aovData]
            ],
            'extra'      => [],
        ];
    }

    // C19: Stok Akhir vs Unit Terjual (Combo Area + Column)
    private function buildC19(array $filters): array
    {
        $rows = $this->opsRepo->getStockVsSold($filters);
        $categories = array_column($rows, 'period');
        $stockData = array_map(fn($r) => (int)$r['total_stock'], $rows);
        $soldData = array_map(fn($r) => (int)$r['units_sold'], $rows);

        return [
            'chart_id'   => 'c19',
            'title'      => 'Stok Akhir vs Unit Terjual',
            'subtitle'   => 'Apakah persediaan stok selaras dengan tingkat permintaan?',
            'type'       => 'combo',
            'unit'       => 'Unit',
            'categories' => $categories,
            'series'     => [
                ['name' => 'Stok Akhir', 'type' => 'area', 'data' => $stockData],
                ['name' => 'Unit Terjual', 'type' => 'column', 'data' => $soldData],
            ],
            'extra'      => [],
        ];
    }

    // C20: Struktur Biaya per Tahun (100% Stacked Bar)
    private function buildC20(array $filters): array
    {
        $rows = $this->opsRepo->getCostStructurePerYear();
        $years = array_values(array_unique(array_column($rows, 'cost_year')));
        $costTypes = array_values(array_unique(array_column($rows, 'cost_type')));

        $typeMap = [];
        foreach ($costTypes as $ct) {
            $typeMap[$ct] = array_fill_keys($years, 0.0);
        }

        foreach ($rows as $r) {
            $typeMap[$r['cost_type']][$r['cost_year']] = (float)$r['total_amount'];
        }

        $series = [];
        foreach ($typeMap as $typeName => $yrVals) {
            $label = ucwords(str_replace('_', ' ', $typeName));
            $series[] = ['name' => $label, 'data' => array_values($yrVals)];
        }

        return [
            'chart_id'   => 'c20',
            'title'      => 'Struktur Biaya Usaha per Tahun',
            'subtitle'   => 'Komponen biaya mana yang paling besar menyerap anggaran?',
            'type'       => 'stacked100HorizontalBar',
            'unit'       => '%',
            'categories' => array_map(fn($y) => (string)$y, $years),
            'series'     => $series,
            'extra'      => [],
        ];
    }

    // C21: Lead Time Produksi per Kategori (Boxplot)
    private function buildC21(array $filters): array
    {
        $grouped = $this->opsRepo->getLeadTimesByCategory();
        $boxData = [];

        foreach ($grouped as $catName => $times) {
            $stat = Stats::boxplot($times);
            $boxData[] = [
                'x' => $catName,
                'y' => [$stat['min'], $stat['q1'], $stat['median'], $stat['q3'], $stat['max']]
            ];
        }

        return [
            'chart_id'   => 'c21',
            'title'      => 'Distribusi Lead Time Produksi per Kategori',
            'subtitle'   => 'Berapa hari produksi per kategori dan seberapa besar variasinya?',
            'type'       => 'boxPlot',
            'unit'       => 'Hari',
            'categories' => array_keys($grouped),
            'series'     => [
                ['name' => 'Lead Time (Hari)', 'data' => $boxData]
            ],
            'extra'      => [],
        ];
    }

    // C22: Prediksi Pendapatan 12 Bulan + Interval Keyakinan 95%
    private function buildC22(array $filters): array
    {
        $run = $this->forecastRepo->getSelectedRun('total');
        if (!$run) {
            return $this->getEmptyForecastChart('c22', 'Prediksi Pendapatan 12 Bulan + Interval 95%');
        }

        $histRows = $this->salesRepo->getMonthlyRevenue([]);
        $histCut = array_slice($histRows, -12); // Last 12 actual months for context

        $futureVals = $this->forecastRepo->getForecastValues($run['id'], 'total', 'future');

        $categories = [];
        $actualSeries = [];
        $forecastSeries = [];
        $upperSeries = [];
        $lowerSeries = [];

        foreach ($histCut as $h) {
            $categories[] = $h['period'];
            $actualSeries[] = (float)$h['revenue'];
            $forecastSeries[] = null;
            $upperSeries[] = null;
            $lowerSeries[] = null;
        }

        $lastActual = end($histCut);
        if ($lastActual) {
            // Anchor point for continuity
            $forecastSeries[count($forecastSeries) - 1] = (float)$lastActual['revenue'];
            $upperSeries[count($upperSeries) - 1] = (float)$lastActual['revenue'];
            $lowerSeries[count($lowerSeries) - 1] = (float)$lastActual['revenue'];
        }

        foreach ($futureVals as $fv) {
            $p = substr($fv['period'], 0, 7);
            $categories[] = $p;
            $actualSeries[] = null;
            $forecastSeries[] = round((float)$fv['point'], 2);
            $upperSeries[] = round((float)$fv['upper'], 2);
            $lowerSeries[] = round((float)$fv['lower'], 2);
        }

        return [
            'chart_id'   => 'c22',
            'title'      => 'Prediksi Pendapatan 12 Bulan + Interval 95%',
            'subtitle'   => 'Berapa proyeksi pendapatan 12 bulan mendatang dan rentang kepastiannya?',
            'type'       => 'line',
            'unit'       => 'IDR',
            'categories' => $categories,
            'series'     => [
                ['name' => 'Aktual Terakhir', 'type' => 'line', 'data' => $actualSeries],
                ['name' => 'Prediksi Holt-Winters', 'type' => 'line', 'data' => $forecastSeries],
                ['name' => 'Batas Atas (95%)', 'type' => 'line', 'data' => $upperSeries],
                ['name' => 'Batas Bawah (95%)', 'type' => 'line', 'data' => $lowerSeries],
            ],
            'extra'      => [
                'model_name' => ucwords(str_replace('_', ' ', $run['model'])),
                'mape'       => (float)$run['mape'],
            ],
        ];
    }

    // C23: Uji Mundur: Aktual vs 3 Model (Backtest Multi-line)
    private function buildC23(array $filters): array
    {
        $runs = $this->forecastRepo->getAllRuns('total');
        if (empty($runs)) {
            return $this->getEmptyForecastChart('c23', 'Uji Mundur: Aktual vs 3 Model');
        }

        // 12 test months: 2025-11 to 2026-10
        $testMonths = [
            '2025-11', '2025-12', '2026-01', '2026-02', '2026-03', '2026-04',
            '2025-05', '2026-06', '2026-07', '2026-08', '2026-09', '2026-10'
        ];
        
        $histRows = $this->salesRepo->getMonthlyRevenue([]);
        $histMap = array_column($histRows, 'revenue', 'period');
        $actuals = [];
        foreach ($testMonths as $m) {
            $actuals[] = isset($histMap[$m]) ? (float)$histMap[$m] : 0.0;
        }

        $series = [
            ['name' => 'Aktual (Data Uji)', 'data' => $actuals]
        ];

        foreach ($runs as $r) {
            $mKey = $r['model'];
            $backtestVals = $this->forecastRepo->getForecastValues($r['id'], 'total', 'backtest');
            $dataPoints = array_map(fn($v) => (float)$v['point'], $backtestVals);
            if (!empty($dataPoints)) {
                $series[] = [
                    'name' => ucwords(str_replace('_', ' ', $mKey)),
                    'data' => $dataPoints,
                ];
            }
        }

        return [
            'chart_id'   => 'c23',
            'title'      => 'Uji Mundur: Aktual vs 3 Model Prediksi',
            'subtitle'   => 'Model mana yang paling akurat mengikuti pola data historis nyata?',
            'type'       => 'line',
            'unit'       => 'IDR',
            'categories' => $testMonths,
            'series'     => $series,
            'extra'      => [],
        ];
    }

    // C24: Perbandingan Akurasi Model (Grouped Bar MAPE & NRMSE)
    private function buildC24(array $filters): array
    {
        $runs = $this->forecastRepo->getAllRuns('total');
        if (empty($runs)) {
            return $this->getEmptyForecastChart('c24', 'Perbandingan Akurasi Model');
        }

        $categories = [];
        $mapeData = [];
        $nrmseData = [];

        foreach ($runs as $r) {
            $categories[] = ucwords(str_replace('_', ' ', $r['model']));
            $mapeData[] = (float)$r['mape'];
            $nrmseData[] = (float)$r['nrmse'];
        }

        return [
            'chart_id'   => 'c24',
            'title'      => 'Perbandingan Akurasi Model Prediksi',
            'subtitle'   => 'Model mana paling akurat berdasarkan MAPE dan NRMSE terendah?',
            'type'       => 'bar',
            'unit'       => '%',
            'categories' => $categories,
            'series'     => [
                ['name' => 'MAPE (%)', 'data' => $mapeData],
                ['name' => 'NRMSE (%)', 'data' => $nrmseData],
            ],
            'extra'      => [],
        ];
    }

    // C25: Prediksi per Kategori Produk (Stacked Column)
    private function buildC25(array $filters): array
    {
        $run = $this->forecastRepo->getSelectedRun('total');
        if (!$run) {
            return $this->getEmptyForecastChart('c25', 'Prediksi per Kategori Produk');
        }

        $cats = (new ProductRepository())->getRevenueByCategory([]);
        $catNames = array_column($cats, 'category_name', 'category_id');

        $allVals = $this->forecastRepo->getForecastValues($run['id'], null, 'future');
        $catSeries = [];
        $periods = [];

        foreach ($allVals as $v) {
            if (str_starts_with($v['series_key'], 'cat:')) {
                $cId = (int)substr($v['series_key'], 4);
                $cName = $catNames[$cId] ?? ("Kategori " . $cId);
                $p = substr($v['period'], 0, 7);
                if (!in_array($p, $periods)) {
                    $periods[] = $p;
                }
                $catSeries[$cName][$p] = (float)$v['point'];
            }
        }

        $series = [];
        foreach ($catSeries as $name => $pVals) {
            $data = [];
            foreach ($periods as $p) {
                $data[] = $pVals[$p] ?? 0.0;
            }
            $series[] = ['name' => $name, 'data' => $data];
        }

        return [
            'chart_id'   => 'c25',
            'title'      => 'Prediksi Penjualan per Kategori Produk',
            'subtitle'   => 'Kategori produk mana yang perlu dipersiapkan stok dan produksinya?',
            'type'       => 'stackedColumn',
            'unit'       => 'IDR',
            'categories' => $periods,
            'series'     => $series,
            'extra'      => [],
        ];
    }

    private function getEmptyForecastChart(string $chartId, string $title): array
    {
        return [
            'chart_id'   => $chartId,
            'title'      => $title,
            'subtitle'   => 'Prediksi belum dijalankan. Silakan jalankan via CLI atau panel admin.',
            'type'       => 'line',
            'unit'       => 'IDR',
            'categories' => [],
            'series'     => [],
            'extra'      => ['is_empty' => true],
        ];
    }
}
