<?php
declare(strict_types=1);

namespace App\Core;

class Auth
{
    private const MAX_ATTEMPTS = 5;
    private const LOCKOUT_SECONDS = 600;

    public static function check(): bool
    {
        return isset($_SESSION['user_id']) && !empty($_SESSION['user_id']);
    }

    public static function user(): ?array
    {
        if (!self::check()) {
            return null;
        }

        return [
            'id'       => $_SESSION['user_id'],
            'username' => $_SESSION['username'] ?? '',
            'role'     => $_SESSION['role'] ?? 'admin',
        ];
    }

    public static function attempt(string $username, string $password): bool
    {
        $ip = $_SERVER['REMOTE_ADDR'] ?? '127.0.0.1';
        if (self::isRateLimited($ip)) {
            return false;
        }

        try {
            $db = Database::getInstance();
            $stmt = $db->prepare("SELECT id, username, password_hash, role FROM users WHERE username = :u LIMIT 1");
            $stmt->execute(['u' => $username]);
            $user = $stmt->fetch();

            if ($user && password_verify($password, $user['password_hash'])) {
                self::resetAttempts($ip);
                $_SESSION['user_id'] = $user['id'];
                $_SESSION['username'] = $user['username'];
                $_SESSION['role'] = $user['role'];
                return true;
            }
        } catch (\Throwable $e) {
            // Fallback check against .env config if database is not yet seeded
            $envUser = Env::get('ADMIN_USER', 'admin');
            $envPass = Env::get('ADMIN_PASS', 'admin123');
            if ($username === $envUser && $password === $envPass) {
                self::resetAttempts($ip);
                $_SESSION['user_id'] = 1;
                $_SESSION['username'] = $envUser;
                $_SESSION['role'] = 'admin';
                return true;
            }
        }

        self::recordFailedAttempt($ip);
        return false;
    }

    public static function logout(): void
    {
        unset($_SESSION['user_id'], $_SESSION['username'], $_SESSION['role']);
        session_regenerate_id(true);
    }

    private static function isRateLimited(string $ip): bool
    {
        $attempts = $_SESSION['login_attempts_' . $ip] ?? 0;
        $lastTime = $_SESSION['login_attempt_time_' . $ip] ?? 0;

        if ($attempts >= self::MAX_ATTEMPTS) {
            if (time() - $lastTime < self::LOCKOUT_SECONDS) {
                return true;
            }
            self::resetAttempts($ip);
        }
        return false;
    }

    private static function recordFailedAttempt(string $ip): void
    {
        $_SESSION['login_attempts_' . $ip] = ($_SESSION['login_attempts_' . $ip] ?? 0) + 1;
        $_SESSION['login_attempt_time_' . $ip] = time();
    }

    private static function resetAttempts(string $ip): void
    {
        unset($_SESSION['login_attempts_' . $ip], $_SESSION['login_attempt_time_' . $ip]);
    }
}
