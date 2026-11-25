<?php
declare(strict_types=1);

namespace App\Services;

use App\Core\Cache;
use App\Forecasting\TimeSeries;
use App\Forecasting\ModelSelector;
use App\Repositories\SalesRepository;
use App\Repositories\ProductRepository;
use App\Repositories\ForecastRepository;

class ForecastService
{
    private SalesRepository $salesRepo;
    private ProductRepository $productRepo;
    private ForecastRepository $forecastRepo;

    public function __construct(
        ?SalesRepository $salesRepo = null,
        ?ProductRepository $productRepo = null,
        ?ForecastRepository $forecastRepo = null
    ) {
        $this->salesRepo    = $salesRepo ?? new SalesRepository();
        $this->productRepo  = $productRepo ?? new ProductRepository();
        $this->forecastRepo = $forecastRepo ?? new ForecastRepository();
    }

    public function runPipeline(): array
    {
        // 1. Fetch Total Monthly Series (46 months)
        $monthlyRows = $this->salesRepo->getMonthlyRevenue([]);
        $series = [];
        foreach ($monthlyRows as $r) {
            $series[$r['period']] = (float)$r['revenue'];
        }

        $totalTs = new TimeSeries($series);

        // 2. Evaluate 3 Models on Holdout (34 train vs 12 test)
        $evalResult = ModelSelector::evaluateAll($totalTs);
        $models      = $evalResult['models'];
        $selectedKey = $evalResult['selected_key'];
        $testPeriods = $evalResult['test_periods'];

        // 3. Clear old runs
        $this->forecastRepo->clearOldRuns('total');

        $selectedRunId = null;

        // 4. Save 3 model runs & backtest values
        foreach ($models as $key => $m) {
            $runId = $this->forecastRepo->saveRun([
                'scope'       => 'total',
                'model'       => $key,
                'params'      => $m['params'],
                'train_start' => '2023-01-01',
                'train_end'   => '2025-10-01',
                'horizon'     => 12,
                'mape'        => $m['metrics']['mape'],
                'rmse'        => $m['metrics']['rmse'],
                'mae'         => $m['metrics']['mae'],
                'nrmse'       => $m['metrics']['nrmse'],
                'is_selected' => $m['is_selected'],
            ]);

            if ($m['is_selected']) {
                $selectedRunId = $runId;
            }

            // Save backtest values
            $backtestVals = [];
            foreach ($m['backtest'] as $idx => $pt) {
                $backtestVals[] = [
                    'series_key' => 'total',
                    'period'     => $testPeriods[$idx],
                    'kind'       => 'backtest',
                    'point'      => $pt,
                    'lower'      => null,
                    'upper'      => null,
                ];
            }
            $this->forecastRepo->saveValues($runId, $backtestVals);
        }

        // 5. Refit Selected Model on Full 46 Months & Forecast 12 Months Ahead
        $forecastResult = ModelSelector::refitAndForecast($selectedKey, $totalTs, 12);
        $futurePeriods  = $forecastResult['future_periods'];
        $intervals      = $forecastResult['intervals'];

        $futureVals = [];
        $totalFutureByPeriod = [];
        foreach ($intervals as $idx => $iv) {
            $p = $futurePeriods[$idx];
            $futureVals[] = [
                'series_key' => 'total',
                'period'     => $p,
                'kind'       => 'future',
                'point'      => $iv['point'],
                'lower'      => $iv['lower'],
                'upper'      => $iv['upper'],
            ];
            $totalFutureByPeriod[$p] = $iv['point'];
        }
        $this->forecastRepo->saveValues($selectedRunId, $futureVals);

        // 6. Category-level forecasting with proportional top-down scaling
        $catTrendRows = $this->productRepo->getCategoryTrend([]);
        $categories   = $this->productRepo->getRevenueByCategory([]);
        
        $catSeries = [];
        foreach ($categories as $cat) {
            $catSeries[$cat['category_id']] = [];
        }
        foreach ($catTrendRows as $r) {
            $cId = (int)$r['category_id'];
            $catSeries[$cId][$r['period']] = (float)$r['revenue'];
        }

        $rawCatForecasts = [];
        foreach ($catSeries as $cId => $pData) {
            $cTs = new TimeSeries($pData);
            $cForecast = ModelSelector::refitAndForecast($selectedKey, $cTs, 12);
            $rawCatForecasts[$cId] = $cForecast['intervals'];
        }

        // Reconcile proportionally
        $scaledCatVals = [];
        foreach ($futurePeriods as $idx => $p) {
            $sumCat = 0.0;
            foreach ($rawCatForecasts as $cId => $ivList) {
                $sumCat += $ivList[$idx]['point'];
            }

            $targetTotal = $totalFutureByPeriod[$p] ?? $sumCat;
            $scaleFactor = $sumCat > 0 ? ($targetTotal / $sumCat) : 1.0;

            foreach ($rawCatForecasts as $cId => $ivList) {
                $scaledPoint = round($ivList[$idx]['point'] * $scaleFactor, 2);
                $scaledCatVals[] = [
                    'series_key' => 'cat:' . $cId,
                    'period'     => $p,
                    'kind'       => 'future',
                    'point'      => $scaledPoint,
                    'lower'      => null,
                    'upper'      => null,
                ];
            }
        }
        $this->forecastRepo->saveValues($selectedRunId, $scaledCatVals);

        // Clear cache so all charts update immediately
        Cache::flush();

        return [
            'status'         => 'success',
            'selected_model' => $selectedKey,
            'selected_run_id'=> $selectedRunId,
            'mape'           => $models[$selectedKey]['metrics']['mape'],
        ];
    }

    public function getSummary(): array
    {
        $run = $this->forecastRepo->getSelectedRun('total');
        if (!$run) {
            return ['has_forecast' => false];
        }

        $allRuns = $this->forecastRepo->getAllRuns('total');
        $futureTotal = $this->forecastRepo->getForecastValues($run['id'], 'total', 'future');
        $recommendations = $this->generateStockRecommendations($run['id']);

        return [
            'has_forecast'    => true,
            'selected_run'    => $run,
            'all_runs'        => $allRuns,
            'future_total'    => $futureTotal,
            'recommendations' => $recommendations,
        ];
    }

    public function generateStockRecommendations(int $runId): array
    {
        $catVals = $this->forecastRepo->getForecastValues($runId, null, 'future');
        $categories = $this->productRepo->getRevenueByCategory([]);
        $catMap = [];
        foreach ($categories as $c) {
            $catMap[$c['category_id']] = [
                'name'      => $c['category_name'],
                'avg_price' => $c['units_sold'] > 0 ? round($c['revenue'] / $c['units_sold']) : 150000,
            ];
        }

        $groupedByCat = [];
        foreach ($catVals as $v) {
            if (str_starts_with($v['series_key'], 'cat:')) {
                $cId = (int)substr($v['series_key'], 4);
                $groupedByCat[$cId][] = $v;
            }
        }

        $leadTimeMap = [
            'Aksesoris'               => ['days' => 5, 'prep_weeks' => 2],
            'Dekorasi & Patung'       => ['days' => 16, 'prep_weeks' => 4],
            'Souvenir'                => ['days' => 4, 'prep_weeks' => 2],
            'Alat Tulis & Fungsional' => ['days' => 7, 'prep_weeks' => 2],
            'Religi & Seremonial'     => ['days' => 9, 'prep_weeks' => 3],
        ];

        $recommendations = [];
        foreach ($groupedByCat as $cId => $vals) {
            $catName = $catMap[$cId]['name'] ?? ("Kategori " . $cId);
            $avgPrice = $catMap[$cId]['avg_price'] ?? 150000;
            $ltInfo = $leadTimeMap[$catName] ?? ['days' => 7, 'prep_weeks' => 2];

            // Find peak month
            $peakPoint = 0.0;
            $peakPeriod = '';
            $totalYearRev = 0.0;

            foreach ($vals as $v) {
                $pt = (float)$v['point'];
                $totalYearRev += $pt;
                if ($pt > $peakPoint) {
                    $peakPoint = $pt;
                    $peakPeriod = substr($v['period'], 0, 7);
                }
            }

            // Target units with 10% safety stock
            $peakUnits = round(($peakPoint / $avgPrice) * 1.10);
            $annualUnits = round(($totalYearRev / $avgPrice) * 1.10);

            // Suggested production start: prep_weeks before peak month
            $peakDt = new \DateTime($peakPeriod . '-01');
            $peakDt->modify("-{$ltInfo['prep_weeks']} weeks");
            $startPrep = $peakDt->format('M Y');

            $recommendations[] = [
                'category_id'   => $cId,
                'category_name' => $catName,
                'lead_time'     => $ltInfo['days'] . ' hari',
                'peak_period'   => date('F Y', strtotime($peakPeriod . '-01')),
                'peak_target'   => number_format($peakUnits, 0, ',', '.') . ' unit',
                'annual_target' => number_format($annualUnits, 0, ',', '.') . ' unit',
                'start_prep'    => $startPrep,
                'action_note'   => "Siapkan bahan kayu eboni & mulai produksi sejak {$startPrep} untuk puncak {$peakPeriod}.",
            ];
        }

        return $recommendations;
    }
}
