<?php
declare(strict_types=1);

namespace App\Support;

class DateRange
{
    private static array $indoMonths = [
        1 => 'Januari', 2 => 'Februari', 3 => 'Maret', 4 => 'April',
        5 => 'Mei', 6 => 'Juni', 7 => 'Juli', 8 => 'Agustus',
        9 => 'September', 10 => 'Oktober', 11 => 'November', 12 => 'Desember'
    ];

    private static array $indoShortMonths = [
        1 => 'Jan', 2 => 'Feb', 3 => 'Mar', 4 => 'Apr',
        5 => 'Mei', 6 => 'Jun', 7 => 'Jul', 8 => 'Agu',
        9 => 'Sep', 10 => 'Okt', 11 => 'Nov', 12 => 'Des'
    ];

    public static function formatMonth(string $yearMonth): string
    {
        // e.g. "2026-03" -> "Mar 2026"
        $parts = explode('-', $yearMonth);
        if (count($parts) < 2) {
            return $yearMonth;
        }
        $year = $parts[0];
        $month = (int)$parts[1];
        return (self::$indoShortMonths[$month] ?? $month) . ' ' . $year;
    }

    public static function formatFullDate(string $ymd): string
    {
        // e.g. "2026-11-22" -> "22 Nov 2026"
        $parts = explode('-', $ymd);
        if (count($parts) < 3) {
            return $ymd;
        }
        $year = $parts[0];
        $month = (int)$parts[1];
        $day = (int)$parts[2];
        return $day . ' ' . (self::$indoShortMonths[$month] ?? $month) . ' ' . $year;
    }

    public static function generateMonthList(string $startMonth, string $endMonth): array
    {
        $months = [];
        $current = new \DateTime($startMonth . '-01');
        $end = new \DateTime($endMonth . '-01');

        while ($current <= $end) {
            $months[] = $current->format('Y-m');
            $current->modify('+1 month');
        }
        return $months;
    }
}
