<?php
declare(strict_types=1);

namespace App\Forecasting;

class HoltWinters
{
    private float $alpha = 0.2;
    private float $beta  = 0.1;
    private float $gamma = 0.3;
    private int $m = 12; // season length
    private string $type = 'multiplicative'; // 'additive' or 'multiplicative'

    public function __construct(float $alpha = 0.2, float $beta = 0.1, float $gamma = 0.3, int $m = 12, string $type = 'multiplicative')
    {
        $this->alpha = $alpha;
        $this->beta = $beta;
        $this->gamma = $gamma;
        $this->m = $m;
        $this->type = $type;
    }

    public function getParams(): array
    {
        return [
            'alpha' => $this->alpha,
            'beta'  => $this->beta,
            'gamma' => $this->gamma,
            'm'     => $this->m,
            'type'  => $this->type,
        ];
    }

    public function fit(array $series): array
    {
        $n = count($series);
        $m = $this->m;

        if ($n < 2 * $m) {
            // Fallback for very short series
            return ['fitted' => $series, 'level' => end($series), 'trend' => 0.0, 'season' => array_fill(0, $m, 1.0)];
        }

        // Initialize Level and Trend
        $cycle1Mean = array_sum(array_slice($series, 0, $m)) / $m;
        $cycle2Mean = array_sum(array_slice($series, $m, $m)) / $m;
        $trend0 = ($cycle2Mean - $cycle1Mean) / $m;
        $level0 = $cycle1Mean;

        // Initialize Seasonal Indices
        $season = [];
        if ($this->type === 'multiplicative') {
            for ($i = 0; $i < $m; $i++) {
                $season[$i] = ($series[$i] + $series[$i + $m]) / (2 * $cycle1Mean);
            }
            // Normalize so sum of seasonal indices = m
            $sSum = array_sum($season);
            if ($sSum > 0) {
                for ($i = 0; $i < $m; $i++) {
                    $season[$i] = ($season[$i] / $sSum) * $m;
                }
            }
        } else {
            // Additive
            for ($i = 0; $i < $m; $i++) {
                $season[$i] = ($series[$i] - $cycle1Mean + $series[$i + $m] - $cycle2Mean) / 2;
            }
            // Normalize so sum = 0
            $sMean = array_sum($season) / $m;
            for ($i = 0; $i < $m; $i++) {
                $season[$i] -= $sMean;
            }
        }

        $levels = [$level0];
        $trends = [$trend0];
        $seasons = $season; // ring of size m or extended
        $fitted = [];

        for ($t = 0; $t < $n; $t++) {
            $prevLevel = $levels[$t];
            $prevTrend = $trends[$t];
            $sIdx = $t % $m;
            $prevSeason = $seasons[$sIdx];

            $y = (float)$series[$t];

            if ($this->type === 'multiplicative') {
                $ySeason = $prevSeason != 0 ? $prevSeason : 1.0;
                $level = $this->alpha * ($y / $ySeason) + (1 - $this->alpha) * ($prevLevel + $prevTrend);
                $trend = $this->beta * ($level - $prevLevel) + (1 - $this->beta) * $prevTrend;
                $newSeason = $this->gamma * ($y / ($level != 0 ? $level : 1.0)) + (1 - $this->gamma) * $prevSeason;
                $fitVal = ($prevLevel + $prevTrend) * $prevSeason;
            } else {
                // Additive
                $level = $this->alpha * ($y - $prevSeason) + (1 - $this->alpha) * ($prevLevel + $prevTrend);
                $trend = $this->beta * ($level - $prevLevel) + (1 - $this->beta) * $prevTrend;
                $newSeason = $this->gamma * ($y - $level) + (1 - $this->gamma) * $prevSeason;
                $fitVal = ($prevLevel + $prevTrend) + $prevSeason;
            }

            $levels[] = $level;
            $trends[] = $trend;
            $seasons[$sIdx] = $newSeason;
            $fitted[] = max(0.0, $fitVal);
        }

        return [
            'fitted'  => $fitted,
            'level'   => end($levels),
            'trend'   => end($trends),
            'seasons' => $seasons,
            'last_idx'=> ($n - 1) % $m,
        ];
    }

    public function predict(array $fitState, int $horizon): array
    {
        $level = $fitState['level'];
        $trend = $fitState['trend'];
        $seasons = $fitState['seasons'];
        $m = $this->m;
        $lastIdx = $fitState['last_idx'];

        $predictions = [];
        for ($h = 1; $h <= $horizon; $h++) {
            $sIdx = ($lastIdx + $h) % $m;
            $s = $seasons[$sIdx];

            if ($this->type === 'multiplicative') {
                $yHat = ($level + $h * $trend) * $s;
            } else {
                $yHat = ($level + $h * $trend) + $s;
            }
            $predictions[] = max(0.0, round($yHat, 2));
        }

        return $predictions;
    }

    public static function gridSearch(array $trainSeries, int $m = 12): self
    {
        $bestModel = new self(0.2, 0.1, 0.3, $m, 'multiplicative');
        $minSSE = INF;

        $types = ['multiplicative', 'additive'];
        $alphas = [0.1, 0.2, 0.3, 0.4, 0.5];
        $betas  = [0.05, 0.1, 0.2];
        $gammas = [0.1, 0.2, 0.3, 0.4];

        foreach ($types as $type) {
            foreach ($alphas as $a) {
                foreach ($betas as $b) {
                    foreach ($gammas as $g) {
                        $model = new self($a, $b, $g, $m, $type);
                        $fit = $model->fit($trainSeries);
                        $fitted = $fit['fitted'];

                        $sse = 0.0;
                        for ($i = $m; $i < count($trainSeries); $i++) {
                            $diff = $trainSeries[$i] - $fitted[$i];
                            $sse += $diff * $diff;
                        }

                        if ($sse < $minSSE) {
                            $minSSE = $sse;
                            $bestModel = $model;
                        }
                    }
                }
            }
        }

        return $bestModel;
    }
}
