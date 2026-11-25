<?php
declare(strict_types=1);

namespace App\Forecasting;

class TimeSeries
{
    private array $data; // ['2023-01' => 28000000, ...]

    public function __construct(array $monthlySeries)
    {
        $this->data = $monthlySeries;
    }

    public function getAll(): array
    {
        return $this->data;
    }

    public function getValues(): array
    {
        return array_values($this->data);
    }

    public function getPeriods(): array
    {
        return array_keys($this->data);
    }

    public function split(int $trainCount = 34): array
    {
        $periods = array_keys($this->data);
        $values  = array_values($this->data);

        $trainValues = array_slice($values, 0, $trainCount);
        $testValues  = array_slice($values, $trainCount);

        $trainPeriods = array_slice($periods, 0, $trainCount);
        $testPeriods  = array_slice($periods, $trainCount);

        return [
            'train' => [
                'periods' => $trainPeriods,
                'values'  => $trainValues,
            ],
            'test'  => [
                'periods' => $testPeriods,
                'values'  => $testValues,
            ]
        ];
    }

    public static function generateFuturePeriods(string $lastPeriod, int $horizon = 12): array
    {
        $future = [];
        $dt = new \DateTime($lastPeriod . '-01');
        for ($i = 0; $i < $horizon; $i++) {
            $dt->modify('+1 month');
            $future[] = $dt->format('Y-m');
        }
        return $future;
    }
}
