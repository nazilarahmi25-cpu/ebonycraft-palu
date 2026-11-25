<?php
declare(strict_types=1);

namespace App\Core;

use PDO;
use PDOException;
use App\Services\SetupService;

class Database
{
    private static ?PDO $instance = null;

    public static function getInstance(): PDO
    {
        if (self::$instance === null) {
            $host = Env::get('DB_HOST', '127.0.0.1');
            $port = Env::get('DB_PORT', '3307');
            $db   = Env::get('DB_NAME', 'ebonycraft');
            $user = Env::get('DB_USER', 'root');
            $pass = Env::get('DB_PASS', '');

            $dsn = "mysql:host={$host};port={$port};dbname={$db};charset=utf8mb4";
            $options = [
                PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
                PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
                PDO::ATTR_EMULATE_PREPARES   => false,
            ];

            try {
                self::$instance = new PDO($dsn, $user, $pass, $options);
            } catch (PDOException $e) {
                // If database doesn't exist (Error 1049 / Unknown database), auto-create and seed
                if ($e->getCode() === 1049 || str_contains($e->getMessage(), 'Unknown database') || str_contains($e->getMessage(), '1049')) {
                    SetupService::initializeDatabase();
                    self::$instance = new PDO($dsn, $user, $pass, $options);
                    return self::$instance;
                }
                throw $e;
            }

            // If database exists but orders table is missing, auto-initialize
            try {
                $tables = self::$instance->query("SHOW TABLES LIKE 'orders'")->fetch();
                if (!$tables) {
                    SetupService::initializeDatabase();
                    self::$instance = new PDO($dsn, $user, $pass, $options);
                }
            } catch (\Throwable $t) {
                // Ignore inspection failure
            }
        }

        return self::$instance;
    }

    public static function getRootConnection(): PDO
    {
        $host = Env::get('DB_HOST', '127.0.0.1');
        $port = Env::get('DB_PORT', '3307');
        $user = Env::get('DB_USER', 'root');
        $pass = Env::get('DB_PASS', '');

        $dsn = "mysql:host={$host};port={$port};charset=utf8mb4";
        $options = [
            PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
            PDO::ATTR_EMULATE_PREPARES   => false,
        ];

        return new PDO($dsn, $user, $pass, $options);
    }
}
