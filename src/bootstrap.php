<?php
declare(strict_types=1);

// PSR-4 Autoloader
spl_autoload_register(function (string $class) {
    $prefix = 'App\\';
    $baseDir = __DIR__ . '/';
    $len = strlen($prefix);
    if (strncmp($prefix, $class, $len) !== 0) {
        return;
    }
    $relativeClass = substr($class, $len);
    $file = $baseDir . str_replace('\\', '/', $relativeClass) . '.php';
    if (file_exists($file)) {
        require_once $file;
    }
});

// Load .env
\App\Core\Env::load(__DIR__ . '/../.env');

// Set Timezone
date_default_timezone_set($_ENV['APP_TIMEZONE'] ?? 'Asia/Makassar');

// Start Session if not CLI
if (php_sapi_name() !== 'cli' && session_status() === PHP_SESSION_NONE) {
    $sessionPath = __DIR__ . '/../storage/cache';
    if (is_dir($sessionPath) && is_writable($sessionPath)) {
        session_save_path($sessionPath);
    }
    @session_start();
}
