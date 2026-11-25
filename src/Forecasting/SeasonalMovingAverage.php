<?php
declare(strict_types=1);

namespace App\Forecasting;

class SeasonalMovingAverage
{
    private array $seasonalIndices = [];
    private float $lastTrend = 0.0;
    private float $trendSlope = 0.0;

    public function fit(array $series, array $periods): array
    {
        $n = count($series);
        $m = 12;

        if ($n < 2 * $m) {
            $this->seasonalIndices = array_fill(1, 12, 1.0);
            $this->lastTrend = end($series);
            return ['fitted' => $series];
        }

        // 1. Centered Moving Average (2x12 CMA)
        $cma = array_fill(0, $n, null);
        for ($i = 6; $i < $n - 6; $i++) {
            $sum1 = array_sum(array_slice($series, $i - 6, 12));
            $sum2 = array_sum(array_slice($series, $i - 5, 12));
            $cma[$i] = ($sum1 + $sum2) / 24.0;
        }

        // 2. Ratios Actual / CMA
        $monthRatios = array_fill(1, 12, []);
        for ($i = 6; $i < $n - 6; $i++) {
            if ($cma[$i] !== null && $cma[$i] > 0) {
                $month = (int)date('n', strtotime($periods[$i] . '-01'));
                $monthRatios[$month][] = $series[$i] / $cma[$i];
            }
        }

        // 3. Average seasonal indices
        $indices = [];
        for ($mo = 1; $mo <= 12; $mo++) {
            $ratios = $monthRatios[$mo];
            $indices[$mo] = !empty($ratios) ? (array_sum($ratios) / count($ratios)) : 1.0;
        }

        // Normalize sum = 12
        $idxSum = array_sum($indices);
        if ($idxSum > 0) {
            for ($mo = 1; $mo <= 12; $mo++) {
                $indices[$mo] = ($indices[$mo] / $idxSum) * 12.0;
            }
        }
        $this->seasonalIndices = $indices;

        // 4. Trend estimation via linear slope on CMA points
        $cmaPoints = [];
        for ($i = 0; $i < $n; $i++) {
            if ($cma[$i] !== null) {
                $cmaPoints[] = ['t' => $i, 'val' => $cma[$i]];
            }
        }
        $cnt = count($cmaPoints);
        if ($cnt >= 2) {
            $meanT = array_sum(array_column($cmaPoints, 't')) / $cnt;
            $meanVal = array_sum(array_column($cmaPoints, 'val')) / $cnt;
            $num = 0.0;
            $den = 0.0;
            foreach ($cmaPoints as $pt) {
                $num += ($pt['t'] - $meanT) * ($pt['val'] - $meanVal);
                $den += ($pt['t'] - $meanT) * ($pt['t'] - $meanT);
            }
            $this->trendSlope = $den > 0 ? ($num / $den) : 0.0;
            $this->lastTrend = $meanVal + $this->trendSlope * ($n - 1 - $meanT);
        } else {
            $this->lastTrend = (float)end($series);
            $this->trendSlope = 0.0;
        }

        // 5. Fitted values
        $fitted = [];
        for ($i = 0; $i < $n; $i++) {
            $month = (int)date('n', strtotime($periods[$i] . '-01'));
            $trendAtT = $this->lastTrend - ($n - 1 - $i) * $this->trendSlope;
            $fitVal = $trendAtT * ($this->seasonalIndices[$month] ?? 1.0);
            $fitted[] = max(0.0, round($fitVal, 2));
        }

        return ['fitted' => $fitted];
    }

    public function predict(int $startT, array $futurePeriods): array
    {
        $predictions = [];
        $step = 1;
        foreach ($futurePeriods as $period) {
            $month = (int)date('n', strtotime($period . '-01'));
            $trendAtStep = $this->lastTrend + $step * $this->trendSlope;
            $val = $trendAtStep * ($this->seasonalIndices[$month] ?? 1.0);
            $predictions[] = max(0.0, round($val, 2));
            $step++;
        }
        return $predictions;
    }

    public function getParams(): array
    {
        return [
            'seasonal_indices' => array_map(fn($v) => round($v, 4), $this->seasonalIndices),
            'trend_slope'      => round($this->trendSlope, 2),
            'last_trend'       => round($this->lastTrend, 2),
        ];
    }
}
