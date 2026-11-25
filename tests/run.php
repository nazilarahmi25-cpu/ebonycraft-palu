<?php
declare(strict_types=1);

require_once __DIR__ . '/../src/bootstrap.php';
require_once __DIR__ . '/Unit/MetricsTest.php';
require_once __DIR__ . '/Unit/ForecastingTest.php';
require_once __DIR__ . '/Unit/SupportTest.php';

echo "=== [EbonyCraft Palu] Menjalankan Test Suite Unit ===\n";

$start = microtime(true);

(new \Tests\Unit\MetricsTest())->run();
(new \Tests\Unit\ForecastingTest())->run();
(new \Tests\Unit\SupportTest())->run();

$elapsed = round((microtime(true) - $start) * 1000, 2);
echo "=== Semua Test Suite LULUS 100% ({$elapsed} ms) ===\n";
