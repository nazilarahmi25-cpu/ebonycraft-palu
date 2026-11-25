<?php
declare(strict_types=1);

namespace Tests\Unit;

use App\Support\Money;
use App\Support\DateRange;
use App\Support\Stats;

class SupportTest
{
    public function run(): void
    {
        // Money Format
        assert(Money::format(150000) === 'Rp 150.000');
        assert(Money::compact(28500000) === 'Rp 28,5 jt');
        assert(Money::compact(1750000000) === 'Rp 1,75 M');
        assert(Money::compact(85000) === 'Rp 85 rb');
        assert(Money::percent(12.45, 1) === '12,5%');

        // DateRange
        assert(DateRange::formatMonth('2026-03') === 'Mar 2026');
        assert(DateRange::formatFullDate('2026-11-22') === '22 Nov 2026');

        // Stats Boxplot
        $values = [3, 4, 5, 7, 8, 9, 12, 15, 21];
        $box = Stats::boxplot($values);
        assert($box['min'] === 3.0);
        assert($box['max'] === 21.0);
        assert($box['median'] === 8.0);

        // Stats Histogram
        $histValues = [35000, 45000, 85000, 120000, 150000, 275000, 350000];
        $hist = Stats::histogram($histValues, 100000, 500000);
        assert(count($hist['categories']) === 5);
        assert(array_sum($hist['data']) === count($histValues));

        echo "  [✓] SupportTest: Format rupiah, tanggal, boxplot & histogram lulus.\n";
    }
}
