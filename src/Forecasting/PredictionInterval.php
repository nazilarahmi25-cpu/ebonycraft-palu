<?php
declare(strict_types=1);

namespace App\Forecasting;

class PredictionInterval
{
    /**
     * Computes 95% confidence intervals:
     * lower/upper = yHat +/- 1.96 * sigma_resid * sqrt(1 + (h-1)*alpha^2)
     * Lower bound truncated at >= 0.
     */
    public static function calculate(array $predictions, float $residualStdDev, float $alpha = 0.2): array
    {
        $intervals = [];
        $z = 1.96; // 95% normal quantile

        for ($h = 1; $h <= count($predictions); $h++) {
            $yHat = (float)$predictions[$h - 1];
            $margin = $z * $residualStdDev * sqrt(1 + ($h - 1) * ($alpha * $alpha));

            $lower = max(0.0, round($yHat - $margin, 2));
            $upper = round($yHat + $margin, 2);

            $intervals[] = [
                'point' => $yHat,
                'lower' => $lower,
                'upper' => $upper,
            ];
        }

        return $intervals;
    }

    public static function residualStdDev(array $actual, array $fitted): float
    {
        $n = min(count($actual), count($fitted));
        if ($n <= 1) return 0.0;

        $sumSq = 0.0;
        for ($i = 0; $i < $n; $i++) {
            $diff = (float)$actual[$i] - (float)$fitted[$i];
            $sumSq += $diff * $diff;
        }

        return sqrt($sumSq / ($n - 1));
    }
}
