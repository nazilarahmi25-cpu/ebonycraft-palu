<?php
declare(strict_types=1);

namespace App\Forecasting;

class SeasonalRegression
{
    private array $coefficients = []; // [intercept, trend, d1..d11]
    private int $m = 12;

    public function fit(array $series, array $periods): array
    {
        $n = count($series);
        if ($n < 13) {
            // Not enough data for 13 parameters
            $this->coefficients = array_fill(0, 13, 0.0);
            return ['fitted' => $series];
        }

        // Build Design Matrix X and vector Y
        // Columns: [0: Intercept, 1: Trend (t=1..n), 2..12: Dummies for Month 1..11]
        $p = 13;
        $XtX = array_fill(0, $p, array_fill(0, $p, 0.0));
        $XtY = array_fill(0, $p, 0.0);

        for ($i = 0; $i < $n; $i++) {
            $t = $i + 1;
            $month = (int)date('n', strtotime($periods[$i] . '-01'));
            
            $row = array_fill(0, $p, 0.0);
            $row[0] = 1.0;
            $row[1] = (float)$t;
            if ($month >= 1 && $month <= 11) {
                $row[1 + $month] = 1.0;
            }

            $y = (float)$series[$i];

            for ($j = 0; $j < $p; $j++) {
                $XtY[$j] += $row[$j] * $y;
                for ($k = 0; $k < $p; $k++) {
                    $XtX[$j][$k] += $row[$j] * $row[$k];
                }
            }
        }

        // Solve XtX * beta = XtY using Gauss-Jordan Elimination
        $this->coefficients = $this->solveLinearSystem($XtX, $XtY);

        $fitted = [];
        for ($i = 0; $i < $n; $i++) {
            $t = $i + 1;
            $month = (int)date('n', strtotime($periods[$i] . '-01'));
            $val = $this->predictPoint($t, $month);
            $fitted[] = max(0.0, round($val, 2));
        }

        return ['fitted' => $fitted];
    }

    public function predict(int $startT, array $futurePeriods): array
    {
        $predictions = [];
        $t = $startT;
        foreach ($futurePeriods as $period) {
            $month = (int)date('n', strtotime($period . '-01'));
            $val = $this->predictPoint($t, $month);
            $predictions[] = max(0.0, round($val, 2));
            $t++;
        }
        return $predictions;
    }

    public function getParams(): array
    {
        return [
            'coefficients' => array_map(fn($v) => round($v, 4), $this->coefficients),
            'model'        => 'OLS with 11 Seasonal Dummies',
        ];
    }

    private function predictPoint(int $t, int $month): float
    {
        if (empty($this->coefficients)) {
            return 0.0;
        }

        $val = $this->coefficients[0] + $this->coefficients[1] * $t;
        if ($month >= 1 && $month <= 11 && isset($this->coefficients[1 + $month])) {
            $val += $this->coefficients[1 + $month];
        }
        return $val;
    }

    private function solveLinearSystem(array $A, array $b): array
    {
        $n = count($b);
        // Augment matrix
        for ($i = 0; $i < $n; $i++) {
            $A[$i][] = $b[$i];
        }

        for ($i = 0; $i < $n; $i++) {
            // Find pivot
            $maxRow = $i;
            for ($k = $i + 1; $k < $n; $k++) {
                if (abs($A[$k][$i]) > abs($A[$maxRow][$i])) {
                    $maxRow = $k;
                }
            }

            // Swap rows
            $temp = $A[$i];
            $A[$i] = $A[$maxRow];
            $A[$maxRow] = $temp;

            // Normalize pivot row
            $pivot = $A[$i][$i];
            if (abs($pivot) < 1e-9) {
                continue; // Singular or near-singular
            }

            for ($j = $i; $j <= $n; $j++) {
                $A[$i][$j] /= $pivot;
            }

            // Eliminate column in other rows
            for ($k = 0; $k < $n; $k++) {
                if ($k !== $i) {
                    $factor = $A[$k][$i];
                    for ($j = $i; $j <= $n; $j++) {
                        $A[$k][$j] -= $factor * $A[$i][$j];
                    }
                }
            }
        }

        $x = [];
        for ($i = 0; $i < $n; $i++) {
            $x[$i] = $A[$i][$n];
        }
        return $x;
    }
}
