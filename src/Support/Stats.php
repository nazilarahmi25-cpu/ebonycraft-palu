<?php
declare(strict_types=1);

namespace App\Support;

class Stats
{
    public static function boxplot(array $values): array
    {
        if (empty($values)) {
            return ['min' => 0, 'q1' => 0, 'median' => 0, 'q3' => 0, 'max' => 0];
        }

        sort($values);
        $count = count($values);

        $min = (float)$values[0];
        $max = (float)$values[$count - 1];
        $median = self::percentile($values, 0.50);
        $q1 = self::percentile($values, 0.25);
        $q3 = self::percentile($values, 0.75);

        return [
            'min'    => round($min, 1),
            'q1'     => round($q1, 1),
            'median' => round($median, 1),
            'q3'     => round($q3, 1),
            'max'    => round($max, 1),
        ];
    }

    public static function percentile(array $sortedValues, float $percentile): float
    {
        $count = count($sortedValues);
        if ($count === 0) return 0.0;
        if ($count === 1) return (float)$sortedValues[0];

        $index = ($count - 1) * $percentile;
        $lower = (int)floor($index);
        $fraction = $index - $lower;

        if ($lower >= $count - 1) {
            return (float)$sortedValues[$count - 1];
        }

        return (float)($sortedValues[$lower] + $fraction * ($sortedValues[$lower + 1] - $sortedValues[$lower]));
    }

    public static function histogram(array $values, int $binSize = 50_000, ?int $maxBin = null): array
    {
        if (empty($values)) {
            return ['categories' => [], 'data' => []];
        }

        $maxVal = $maxBin ?? (int)(ceil(max($values) / $binSize) * $binSize);
        $bins = [];
        for ($start = 0; $start < $maxVal; $start += $binSize) {
            $end = $start + $binSize;
            $label = Money::compact($start) . ' - ' . Money::compact($end);
            $bins[$label] = 0;
        }

        foreach ($values as $val) {
            $bIdx = (int)floor($val / $binSize) * $binSize;
            if ($bIdx >= $maxVal) {
                $bIdx = $maxVal - $binSize;
            }
            $label = Money::compact($bIdx) . ' - ' . Money::compact($bIdx + $binSize);
            if (isset($bins[$label])) {
                $bins[$label]++;
            }
        }

        return [
            'categories' => array_keys($bins),
            'data'       => array_values($bins)
        ];
    }
}
