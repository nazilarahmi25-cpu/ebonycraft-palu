<?php
declare(strict_types=1);

namespace App\Controllers;

use App\Core\Auth;
use App\Core\Csrf;
use App\Core\Request;
use App\Core\Response;

class AuthController
{
    public function login(Request $request): void
    {
        $username = trim((string)$request->input('username', ''));
        $password = (string)$request->input('password', '');
        $token    = (string)$request->input('csrf_token', '');

        if (!Csrf::validate($token)) {
            Response::error('Token CSRF tidak valid. Silakan muat ulang halaman.', 'CSRF_ERROR', 403);
        }

        if (empty($username) || empty($password)) {
            Response::error('Username dan password wajib diisi.', 'VALIDATION_ERROR', 400);
        }

        if (Auth::attempt($username, $password)) {
            Response::json([
                'status'  => 'success',
                'message' => 'Login berhasil.',
                'user'    => Auth::user(),
            ]);
        } else {
            Response::error('Username atau password salah, atau batas percobaan terlampaui.', 'AUTH_FAILED', 401);
        }
    }

    public function logout(Request $request): void
    {
        Auth::logout();
        $base = dirname($_SERVER['SCRIPT_NAME'] ?? '');
        Response::redirect($base === '/' || $base === '\\' ? '/' : $base . '/');
    }
}
