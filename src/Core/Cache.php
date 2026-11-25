<?php
declare(strict_types=1);

namespace App\Core;

class Cache
{
    private static string $cacheDir = __DIR__ . '/../../storage/cache/';

    public static function get(string $key, array $filters = []): ?array
    {
        $file = self::getFilePath($key, $filters);
        if (!file_exists($file)) {
            return null;
        }

        $ttl = (int)Env::get('CACHE_TTL', 600);
        if ((time() - filemtime($file)) > $ttl) {
            @unlink($file);
            return null;
        }

        $content = file_get_contents($file);
        if ($content === false) {
            return null;
        }

        $data = json_decode($content, true);
        return is_array($data) ? $data : null;
    }

    public static function set(string $key, array $data, array $filters = []): void
    {
        if (!is_dir(self::$cacheDir)) {
            mkdir(self::$cacheDir, 0777, true);
        }

        $file = self::getFilePath($key, $filters);
        file_put_contents($file, json_encode($data, JSON_UNESCAPED_UNICODE));
    }

    public static function flush(): int
    {
        if (!is_dir(self::$cacheDir)) {
            return 0;
        }

        $files = glob(self::$cacheDir . '*.json');
        $count = 0;
        if ($files) {
            foreach ($files as $file) {
                if (is_file($file)) {
                    unlink($file);
                    $count++;
                }
            }
        }
        return $count;
    }

    private static function getFilePath(string $key, array $filters): string
    {
        ksort($filters);
        $filterHash = md5(json_encode($filters));
        $sanitizedKey = preg_replace('/[^a-zA-Z0-9_\-]/', '_', $key);
        return self::$cacheDir . "cache_{$sanitizedKey}_{$filterHash}.json";
    }
}
