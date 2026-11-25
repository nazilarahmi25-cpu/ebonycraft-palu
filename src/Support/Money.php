<?php
declare(strict_types=1);

namespace App\Support;

class Money
{
    public static function format(int|float $amount): string
    {
        return 'Rp ' . number_format((float)$amount, 0, ',', '.');
    }

    public static function compact(int|float $amount): string
    {
        $abs = abs($amount);
        $sign = $amount < 0 ? '-' : '';

        if ($abs >= 1_000_000_000) {
            $val = round($abs / 1_000_000_000, 2);
            return $sign . 'Rp ' . str_replace('.', ',', (string)$val) . ' M';
        }
        if ($abs >= 1_000_000) {
            $val = round($abs / 1_000_000, 1);
            return $sign . 'Rp ' . str_replace('.', ',', (string)$val) . ' jt';
        }
        if ($abs >= 1_000) {
            $val = round($abs / 1_000, 0);
            return $sign . 'Rp ' . number_format($val, 0, ',', '.') . ' rb';
        }

        return $sign . 'Rp ' . number_format($abs, 0, ',', '.');
    }

    public static function percent(float $val, int $decimals = 1): string
    {
        return number_format($val, $decimals, ',', '.') . '%';
    }
}
