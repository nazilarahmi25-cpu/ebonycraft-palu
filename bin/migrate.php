<?php
declare(strict_types=1);

require_once __DIR__ . '/../src/bootstrap.php';

use App\Core\Database;
use App\Core\Env;
use App\Repositories\UserRepository;

echo "=== [EbonyCraft Palu] Database Migration ===\n";

$host = Env::get('DB_HOST', '127.0.0.1');
$port = Env::get('DB_PORT', '3307');
$dbName = Env::get('DB_NAME', 'ebonycraft');
$user = Env::get('DB_USER', 'root');
$pass = Env::get('DB_PASS', '');

try {
    // 1. Connect without dbname to ensure database exists
    $rootPdo = Database::getRootConnection();
    echo "[+] Memeriksa basis data '{$dbName}'...\n";
    $rootPdo->exec("CREATE DATABASE IF NOT EXISTS `{$dbName}` CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;");
    echo "[✓] Basis data '{$dbName}' siap.\n";

    // 2. Connect to database
    $pdo = Database::getInstance();

    // 3. Read & Execute schema.sql
    $schemaFile = __DIR__ . '/../database/schema.sql';
    if (!file_exists($schemaFile)) {
        throw new RuntimeException("File {$schemaFile} tidak ditemukan!");
    }

    echo "[+] Menjalankan skrip database/schema.sql...\n";
    $sql = file_get_contents($schemaFile);
    $pdo->exec($sql);
    echo "[✓] Skema 11 tabel berhasil dibuat!\n";

    // 4. Create default admin user
    $adminUser = Env::get('ADMIN_USER', 'admin');
    $adminPass = Env::get('ADMIN_PASS', 'admin123');
    echo "[+] Menyiapkan akun admin default ('{$adminUser}')...\n";
    $userRepo = new UserRepository($pdo);
    $userRepo->createOrUpdateAdmin($adminUser, $adminPass);
    echo "[✓] Akun admin '{$adminUser}' siap (password: {$adminPass}).\n";

    echo "=== Migrasi Selesai dengan Sukses ===\n";
} catch (Throwable $e) {
    echo "[!] Kesalahan migrasi: " . $e->getMessage() . "\n";
    exit(1);
}
