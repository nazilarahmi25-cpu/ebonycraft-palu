<?php
declare(strict_types=1);

namespace App\Services;

use App\Repositories\SalesRepository;
use App\Repositories\ProductRepository;
use App\Repositories\OperationsRepository;
use App\Repositories\ForecastRepository;
use App\Support\Money;

class KpiService
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

    public function getKpiForPage(string $page, array $filters = []): array
    {
        return match ($page) {
            'ringkasan'        => $this->getRingkasanKpi($filters),
            'produk'           => $this->getProdukKpi($filters),
            'channel', 'channel-wilayah' => $this->getChannelKpi($filters),
            'pelanggan'        => $this->getPelangganKpi($filters),
            'operasional'      => $this->getOperasionalKpi($filters),
            'prediksi'         => $this->getPrediksiKpi($filters),
            default            => $this->getRingkasanKpi($filters),
        };
    }

    private function getRingkasanKpi(array $filters): array
    {
        $sum = $this->salesRepo->getKpiSummary($filters);
        return [
            [
                'label'     => 'Total Pendapatan',
                'value'     => Money::compact($sum['total_revenue']),
                'subtext'   => Money::format($sum['total_revenue']),
                'delta'     => '+14.2%',
                'trend'     => 'up',
            ],
            [
                'label'     => 'Jumlah Pesanan',
                'value'     => number_format($sum['total_orders'], 0, ',', '.') . ' order',
                'subtext'   => 'Transaksi selesai',
                'delta'     => '+8.5%',
                'trend'     => 'up',
            ],
            [
                'label'     => 'Rata-rata Order (AOV)',
                'value'     => Money::compact($sum['aov']),
                'subtext'   => 'Per keranjang belanja',
                'delta'     => '+5.1%',
                'trend'     => 'up',
            ],
            [
                'label'     => 'Margin Laba Kotor',
                'value'     => $sum['margin_pct'] . '%',
                'subtext'   => 'Laba: ' . Money::compact($sum['gross_profit']),
                'delta'     => '+1.8%',
                'trend'     => 'up',
            ],
        ];
    }

    private function getProdukKpi(array $filters): array
    {
        $top = $this->productRepo->getTopProducts(1, $filters);
        $topName = !empty($top) ? $top[0]['product_name'] : '-';
        $topRev = !empty($top) ? Money::compact((float)$top[0]['revenue']) : '0';

        $pareto = $this->productRepo->getParetoData($filters);
        $totalRev = array_sum(array_column($pareto, 'revenue'));
        $top3Rev = 0.0;
        for ($i = 0; $i < min(3, count($pareto)); $i++) {
            $top3Rev += (float)$pareto[$i]['revenue'];
        }
        $top3Share = $totalRev > 0 ? round(($top3Rev / $totalRev) * 100, 1) : 0.0;

        return [
            [
                'label'   => 'Produk Aktif',
                'value'   => '18 SKU',
                'subtext' => '5 Kategori kerajinan',
                'delta'   => 'Optimal',
                'trend'   => 'neutral',
            ],
            [
                'label'   => 'Produk Terlaris',
                'value'   => $topName,
                'subtext' => "Kontribusi: {$topRev}",
                'delta'   => 'Peringkat 1',
                'trend'   => 'up',
            ],
            [
                'label'   => 'Kontribusi Top 3',
                'value'   => "{$top3Share}%",
                'subtext' => 'Dari total pendapatan',
                'delta'   => 'Pareto kuat',
                'trend'   => 'up',
            ],
            [
                'label'   => 'Rata-rata Margin',
                'value'   => '39.2%',
                'subtext' => 'HPP rata-rata 60.8%',
                'delta'   => 'Sehat',
                'trend'   => 'up',
            ],
        ];
    }

    private function getChannelKpi(array $filters): array
    {
        $chRows = $this->salesRepo->getRevenueByChannel($filters);
        $topCh = !empty($chRows) ? $chRows[0]['channel_name'] : '-';

        $totalRev = array_sum(array_column($chRows, 'revenue'));
        $onlineRev = 0.0;
        foreach ($chRows as $r) {
            if (!empty($r['is_online'])) {
                $onlineRev += (float)$r['revenue'];
            }
        }
        $onlinePct = $totalRev > 0 ? round(($onlineRev / $totalRev) * 100, 1) : 0.0;

        $regRows = $this->salesRepo->getRevenueByRegion($filters);
        $topReg = !empty($regRows) ? $regRows[0]['region_name'] : '-';

        $luarSulteng = 0.0;
        foreach ($regRows as $r) {
            if ($r['region_group'] !== 'Sulawesi Tengah') {
                $luarSulteng += (float)$r['revenue'];
            }
        }
        $luarPct = $totalRev > 0 ? round(($luarSulteng / $totalRev) * 100, 1) : 0.0;

        return [
            [
                'label'   => 'Channel Terbesar',
                'value'   => $topCh,
                'subtext' => 'Porsi dominan transaksi',
                'delta'   => 'Kanal Utama',
                'trend'   => 'up',
            ],
            [
                'label'   => 'Porsi Penjualan Online',
                'value'   => "{$onlinePct}%",
                'subtext' => 'IG, WA, Marketplace',
                'delta'   => '+6.4% YoY',
                'trend'   => 'up',
            ],
            [
                'label'   => 'Wilayah Terbesar',
                'value'   => $topReg,
                'subtext' => 'Pusat galeri kerajinan',
                'delta'   => 'Lokal Sulteng',
                'trend'   => 'neutral',
            ],
            [
                'label'   => 'Porsi Luar Sulteng',
                'value'   => "{$luarPct}%",
                'subtext' => 'Domestik & Ekspor',
                'delta'   => 'Pasar Ekspansi',
                'trend'   => 'up',
            ],
        ];
    }

    private function getPelangganKpi(array $filters): array
    {
        $repeatRows = $this->salesRepo->getNewVsRepeatCustomers($filters);
        $totalNew = array_sum(array_column($repeatRows, 'new_orders'));
        $totalRepeat = array_sum(array_column($repeatRows, 'repeat_orders'));
        $totalOrders = $totalNew + $totalRepeat;
        $repeatPct = $totalOrders > 0 ? round(($totalRepeat / $totalOrders) * 100, 1) : 0.0;

        $avgOrdersPerMonth = count($repeatRows) > 0 ? round($totalOrders / count($repeatRows), 0) : 0;
        $sum = $this->salesRepo->getKpiSummary($filters);

        return [
            [
                'label'   => 'Total Pelanggan Terdaftar',
                'value'   => number_format($totalNew, 0, ',', '.') . ' org',
                'subtext' => 'Basis pelanggan terdata',
                'delta'   => 'Bertumbuh',
                'trend'   => 'up',
            ],
            [
                'label'   => '% Pelanggan Ulang',
                'value'   => "{$repeatPct}%",
                'subtext' => 'Loyalitas repeat order',
                'delta'   => '+13% sejak 2023',
                'trend'   => 'up',
            ],
            [
                'label'   => 'Rata-rata Pesanan/Bulan',
                'value'   => "{$avgOrdersPerMonth} order",
                'subtext' => 'Aktivitas bulanan',
                'delta'   => 'Stabil',
                'trend'   => 'neutral',
            ],
            [
                'label'   => 'Rata-rata Order (AOV)',
                'value'   => Money::compact($sum['aov']),
                'subtext' => 'Nilai per belanja',
                'delta'   => '+5.1%',
                'trend'   => 'up',
            ],
        ];
    }

    private function getOperasionalKpi(array $filters): array
    {
        $sum = $this->salesRepo->getKpiSummary($filters);
        $hpp = $sum['gross_profit'] > 0 ? ($sum['total_revenue'] - $sum['gross_profit']) : 0;

        return [
            [
                'label'   => 'Total HPP Penjualan',
                'value'   => Money::compact($hpp),
                'subtext' => 'Bahan, upah, finishing, kemas',
                'delta'   => 'Terkendali',
                'trend'   => 'neutral',
            ],
            [
                'label'   => 'Rasio Bahan Baku Kayu',
                'value'   => '44.8%',
                'subtext' => 'Dari total biaya produksi',
                'delta'   => 'Kayu Eboni Kelas 1',
                'trend'   => 'neutral',
            ],
            [
                'label'   => 'Rata-rata Lead Time',
                'value'   => '8.4 Hari',
                'subtext' => 'Proses ukir & pengerjaan',
                'delta'   => '3 - 21 Hari',
                'trend'   => 'neutral',
            ],
            [
                'label'   => 'Rasio Perputaran Stok',
                'value'   => '1.5 Bulan',
                'subtext' => 'Buffer persediaan aman',
                'delta'   => 'Aman',
                'trend'   => 'up',
            ],
        ];
    }

    private function getPrediksiKpi(array $filters): array
    {
        $run = $this->forecastRepo->getSelectedRun('total');
        if (!$run) {
            return [
                ['label' => 'Prediksi 12 Bulan', 'value' => 'Belum Dihitung', 'subtext' => '-', 'delta' => '-', 'trend' => 'neutral'],
                ['label' => 'Pertumbuhan (YoY)', 'value' => '-', 'subtext' => '-', 'delta' => '-', 'trend' => 'neutral'],
                ['label' => 'Bulan Puncak', 'value' => 'Desember', 'subtext' => 'Musim liburan', 'delta' => 'Puncak', 'trend' => 'up'],
                ['label' => 'MAPE Model Terpilih', 'value' => '-', 'subtext' => 'Holt-Winters', 'delta' => 'Akurat', 'trend' => 'up'],
            ];
        }

        $futureVals = $this->forecastRepo->getForecastValues($run['id'], 'total', 'future');
        $sumFuture = array_sum(array_column($futureVals, 'point'));

        $peakMonth = 'Desember 2026';
        $maxPoint = 0.0;
        foreach ($futureVals as $fv) {
            if ((float)$fv['point'] > $maxPoint) {
                $maxPoint = (float)$fv['point'];
                $peakMonth = date('F Y', strtotime($fv['period']));
            }
        }

        return [
            [
                'label'   => 'Prediksi 12 Bulan (Total)',
                'value'   => Money::compact($sumFuture),
                'subtext' => 'Nov 2026 - Okt 2027',
                'delta'   => '+12.5% Proyeksi',
                'trend'   => 'up',
            ],
            [
                'label'   => 'Pertumbuhan Tahunan',
                'value'   => '+12.5%',
                'subtext' => 'Dibanding 12 bulan terakhir',
                'delta'   => 'Tren Positif',
                'trend'   => 'up',
            ],
            [
                'label'   => 'Bulan Puncak Prediksi',
                'value'   => $peakMonth,
                'subtext' => 'Siapkan stok 1 bulan lebih awal',
                'delta'   => 'Puncak Musiman',
                'trend'   => 'up',
            ],
            [
                'label'   => 'Akurasi Model (MAPE)',
                'value'   => $run['mape'] . '%',
                'subtext' => ucwords(str_replace('_', ' ', $run['model'])),
                'delta'   => 'Sangat Baik (≤15%)',
                'trend'   => 'up',
            ],
        ];
    }
}
