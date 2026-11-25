<?php
declare(strict_types=1);

namespace App\Repositories;

use App\Core\Database;
use PDO;

class UserRepository
{
    private PDO $db;

    public function __construct(?PDO $db = null)
    {
        $this->db = $db ?? Database::getInstance();
    }

    public function findByUsername(string $username): ?array
    {
        $stmt = $this->db->prepare("SELECT * FROM users WHERE username = :u LIMIT 1");
        $stmt->execute(['u' => $username]);
        return $stmt->fetch() ?: null;
    }

    public function createOrUpdateAdmin(string $username, string $password): void
    {
        $hash = password_hash($password, PASSWORD_BCRYPT);
        $sql = "
            INSERT INTO users (username, password_hash, role)
            VALUES (:u, :p, 'admin')
            ON DUPLICATE KEY UPDATE password_hash = VALUES(password_hash)
        ";
        $stmt = $this->db->prepare($sql);
        $stmt->execute(['u' => $username, 'p' => $hash]);
    }
}
