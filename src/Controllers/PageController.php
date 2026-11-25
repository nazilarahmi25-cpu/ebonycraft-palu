<?php
declare(strict_types=1);

namespace App\Controllers;

use App\Core\Auth;
use App\Core\Request;
use App\Core\View;

class PageController
{
    public function dashboard(Request $request): void
    {
        View::render('pages/dashboard', [
            'active_page' => 'all',
            'title'       => 'Dashboard Analisis & Prediksi (25 Chart) — EbonyCraft Palu',
            'is_admin'    => Auth::check(),
        ]);
    }

    public function ringkasan(Request $request): void
    {
        View::render('pages/dashboard', [
            'active_page' => 'ringkasan',
            'title'       => 'Ringkasan Penjualan — EbonyCraft Palu',
            'is_admin'    => Auth::check(),
        ]);
    }

    public function produk(Request $request): void
    {
        View::render('pages/dashboard', [
            'active_page' => 'produk',
            'title'       => 'Analisis Produk Eboni — EbonyCraft Palu',
            'is_admin'    => Auth::check(),
        ]);
    }

    public function channelWilayah(Request $request): void
    {
        View::render('pages/dashboard', [
            'active_page' => 'channel',
            'title'       => 'Channel & Wilayah — EbonyCraft Palu',
            'is_admin'    => Auth::check(),
        ]);
    }

    public function pelanggan(Request $request): void
    {
        View::render('pages/dashboard', [
            'active_page' => 'pelanggan',
            'title'       => 'Pelanggan & Transaksi — EbonyCraft Palu',
            'is_admin'    => Auth::check(),
        ]);
    }

    public function operasional(Request $request): void
    {
        View::render('pages/dashboard', [
            'active_page' => 'operasional',
            'title'       => 'Operasional & Biaya — EbonyCraft Palu',
            'is_admin'    => Auth::check(),
        ]);
    }

    public function prediksi(Request $request): void
    {
        View::render('pages/dashboard', [
            'active_page' => 'prediksi',
            'title'       => 'Prediksi Penjualan 12 Bulan — EbonyCraft Palu',
            'is_admin'    => Auth::check(),
        ]);
    }

    public function login(Request $request): void
    {
        if (Auth::check()) {
            header('Location: ' . dirname($_SERVER['SCRIPT_NAME'] ?? '') . '/');
            exit;
        }

        View::render('auth/login', [
            'active_page' => 'login',
            'title'       => 'Login Admin — EbonyCraft Palu',
            'is_admin'    => false,
        ], null);
    }
}
