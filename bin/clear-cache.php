<?php
declare(strict_types=1);

require_once __DIR__ . '/../src/bootstrap.php';

use App\Core\Cache;

echo "=== [EbonyCraft Palu] Menghapus Cache JSON ===\n";
$count = Cache::flush();
echo "[✓] Berhasil menghapus {$count} file cache dari storage/cache/\n";
