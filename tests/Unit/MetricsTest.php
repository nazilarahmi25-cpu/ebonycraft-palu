<?php
declare(strict_types=1);

namespace Tests\Unit;

use App\Forecasting\Metrics;

class MetricsTest
{
    public function run(): void
    {
        $actual = [100.0, 200.0, 300.0];
        $pred   = [110.0, 190.0, 330.0];

        // MAE: (|10| + |-10| + |30|) / 3 = 50 / 3 = 16.67
        $mae = Metrics::mae($actual, $pred);
        assert(abs($mae - 16.67) < 0.05, "MAE expected ~16.67, got {$mae}");

        // RMSE: sqrt((100 + 100 + 900) / 3) = sqrt(1100 / 3) = sqrt(366.67) = 19.15
        $rmse = Metrics::rmse($actual, $pred);
        assert(abs($rmse - 19.15) < 0.05, "RMSE expected ~19.15, got {$rmse}");

        // MAPE: (10% + 5% + 10%) / 3 = 25% / 3 = 8.33%
        $mape = Metrics::mape($actual, $pred);
        assert(abs($mape - 8.33) < 0.05, "MAPE expected ~8.33, got {$mape}");

        // NRMSE: 19.15 / 200 * 100 = 9.57%
        $nrmse = Metrics::nrmse($actual, $pred);
        assert(abs($nrmse - 9.58) < 0.05, "NRMSE expected ~9.58, got {$nrmse}");

        echo "  [✓] MetricsTest: Semua pengujian metrik akurasi lulus.\n";
    }
}
