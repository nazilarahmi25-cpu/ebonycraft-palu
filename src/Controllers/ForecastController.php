<?php
declare(strict_types=1);

namespace App\Controllers;

use App\Core\Auth;
use App\Core\Csrf;
use App\Core\Request;
use App\Core\Response;
use App\Services\ForecastService;

class ForecastController
{
    private ForecastService $forecastService;

    public function __construct()
    {
        $this->forecastService = new ForecastService();
    }

    public function summary(Request $request): void
    {
        try {
            $summary = $this->forecastService->getSummary();
            Response::json($summary);
        } catch (\Throwable $e) {
            Response::error('Gagal memuat ringkasan prediksi: ' . $e->getMessage(), 'SERVER_ERROR', 500);
        }
    }

    public function run(Request $request): void
    {
        if (!Auth::check()) {
            Response::error('Akses ditolak. Silakan login sebagai admin terlebih dahulu.', 'UNAUTHORIZED', 401);
        }

        $token = $request->input('csrf_token') ?? $request->getBody()['csrf_token'] ?? null;
        if (!Csrf::validate($token)) {
            Response::error('Token CSRF tidak valid.', 'CSRF_ERROR', 403);
        }

        try {
            $result = $this->forecastService->runPipeline();
            Response::json($result);
        } catch (\Throwable $e) {
            Response::error('Gagal menjalankan kalkulasi prediksi: ' . $e->getMessage(), 'FORECAST_ERROR', 500);
        }
    }
}
