<?php
declare(strict_types=1);

namespace App\Forecasting;

class Metrics
{
    public static function mae(array $actual, array $pred): float
    {
        $n = min(count($actual), count($pred));
        if ($n === 0) return 0.0;

        $sum = 0.0;
        for ($i = 0; $i < $n; $i++) {
            $sum += abs((float)$actual[$i] - (float)$pred[$i]);
        }
        return round($sum / $n, 2);
    }

    public static function rmse(array $actual, array $pred): float
    {
        $n = min(count($actual), count($pred));
        if ($n === 0) return 0.0;

        $sumSq = 0.0;
        for ($i = 0; $i < $n; $i++) {
            $diff = (float)$actual[$i] - (float)$pred[$i];
            $sumSq += $diff * $diff;
        }
        return round(sqrt($sumSq / $n), 2);
    }

    public static function mape(array $actual, array $pred): float
    {
        $n = min(count($actual), count($pred));
        if ($n === 0) return 0.0;

        $sumPct = 0.0;
        $validCount = 0;
        for ($i = 0; $i < $n; $i++) {
            $act = (float)$actual[$i];
            if ($act != 0.0) {
                $sumPct += abs(($act - (float)$pred[$i]) / $act);
                $validCount++;
            }
        }
        if ($validCount === 0) return 0.0;

        return round(($sumPct / $validCount) * 100, 2);
    }

    public static function nrmse(array $actual, array $pred): float
    {
        $n = count($actual);
        if ($n === 0) return 0.0;

        $mean = array_sum($actual) / $n;
        if ($mean == 0.0) return 0.0;

        $rmseVal = self::rmse($actual, $pred);
        return round(($rmseVal / $mean) * 100, 2);
    }

    public static function calculateAll(array $actual, array $pred): array
    {
        return [
            'mae'   => self::mae($actual, $pred),
            'rmse'  => self::rmse($actual, $pred),
            'mape'  => self::mape($actual, $pred),
            'nrmse' => self::nrmse($actual, $pred),
        ];
    }
}
