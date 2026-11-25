<?php
declare(strict_types=1);

namespace Tests\Unit;

use App\Forecasting\HoltWinters;
use App\Forecasting\SeasonalRegression;
use App\Forecasting\SeasonalMovingAverage;
use App\Forecasting\PredictionInterval;

class ForecastingTest
{
    public function run(): void
    {
        // 1. Synthetic linear + seasonal monthly series (24 points, cycle 12)
        $series = [];
        $periods = [];
        $seasonalPattern = [1.1, 0.9, 1.0, 1.05, 0.95, 1.2, 1.15, 0.85, 1.0, 0.9, 0.95, 1.3];

        for ($i = 0; $i < 24; $i++) {
            $trend = 100 + 5 * $i;
            $sIdx = $i % 12;
            $val = $trend * $seasonalPattern[$sIdx];
            $series[] = $val;

            $yr = 2024 + (int)floor($i / 12);
            $mo = ($i % 12) + 1;
            $periods[] = sprintf('%04d-%02d', $yr, $mo);
        }

        // Test Holt-Winters
        $hw = new HoltWinters(0.2, 0.1, 0.3, 12, 'multiplicative');
        $fitState = $hw->fit($series);
        $pred = $hw->predict($fitState, 12);
        assert(count($pred) === 12, "Holt-Winters should predict 12 horizons");
        assert($pred[0] > 0, "Forecast points must be positive");

        // Test Determinism (two identical runs produce identical output)
        $fitState2 = $hw->fit($series);
        $pred2 = $hw->predict($fitState2, 12);
        assert($pred === $pred2, "Holt-Winters must be 100% deterministic");

        // Test Seasonal Regression
        $reg = new SeasonalRegression();
        $regFit = $reg->fit($series, $periods);
        $futurePeriods = ['2026-01', '2026-02', '2026-03'];
        $regPred = $reg->predict(25, $futurePeriods);
        assert(count($regPred) === 3, "SeasonalRegression should predict 3 points");

        // Test Prediction Intervals
        $intervals = PredictionInterval::calculate([200.0, 220.0], 10.0, 0.2);
        assert(count($intervals) === 2);
        assert($intervals[0]['lower'] < $intervals[0]['point']);
        assert($intervals[0]['upper'] > $intervals[0]['point']);
        assert($intervals[0]['lower'] >= 0.0, "Lower bound must be >= 0");

        echo "  [✓] ForecastingTest: Semua pengujian model & interval prediksi lulus.\n";
    }
}
