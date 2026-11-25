<?php
declare(strict_types=1);

require_once __DIR__ . '/../src/bootstrap.php';

use App\Core\Request;
use App\Core\Response;
use App\Core\Router;
use App\Controllers\PageController;
use App\Controllers\ChartController;
use App\Controllers\KpiController;
use App\Controllers\FilterController;
use App\Controllers\ForecastController;
use App\Controllers\ExportController;
use App\Controllers\AuthController;
use App\Controllers\ImportController;
use App\Controllers\SetupController;

$router = new Router();

// Page routes
$router->get('/', [PageController::class, 'dashboard']);
$router->get('/produk', [PageController::class, 'produk']);
$router->get('/channel-wilayah', [PageController::class, 'channelWilayah']);
$router->get('/pelanggan', [PageController::class, 'pelanggan']);
$router->get('/operasional', [PageController::class, 'operasional']);
$router->get('/prediksi', [PageController::class, 'prediksi']);
$router->get('/login', [PageController::class, 'login']);
$router->get('/setup', [SetupController::class, 'webSetup']);

// API routes
$router->get('/api/v1/setup', [SetupController::class, 'apiSetup']);
$router->post('/api/v1/setup', [SetupController::class, 'apiSetup']);
$router->get('/api/v1/filters', [FilterController::class, 'index']);
$router->get('/api/v1/kpi', [KpiController::class, 'kpi']);
$router->get('/api/v1/insights', [KpiController::class, 'insights']);
$router->get('/api/v1/charts/{id}', [ChartController::class, 'show']);
$router->get('/api/v1/forecast/summary', [ForecastController::class, 'summary']);
$router->post('/api/v1/forecast/run', [ForecastController::class, 'run']);
$router->get('/api/v1/export/{id}.csv', [ExportController::class, 'exportCsv']);
$router->post('/api/v1/auth/login', [AuthController::class, 'login']);
$router->post('/api/v1/auth/logout', [AuthController::class, 'logout']);
$router->post('/api/v1/import/transactions', [ImportController::class, 'transactions']);
$router->post('/api/v1/cache/clear', function (Request $request) {
    if (!\App\Core\Auth::check()) {
        Response::error('Akses ditolak. Silakan login sebagai admin.', 'UNAUTHORIZED', 401);
    }
    $token = $request->input('csrf_token') ?? $request->getBody()['csrf_token'] ?? null;
    if (!\App\Core\Csrf::validate($token)) {
        Response::error('Token CSRF tidak valid.', 'CSRF_ERROR', 403);
    }
    $cleared = \App\Core\Cache::flush();
    Response::json([
        'status' => 'success',
        'message' => "Cache berhasil dibersihkan ({$cleared} berkas dihapus).",
        'cleared_files' => $cleared,
    ]);
});

// Dispatch Request with global error guard
$request = new Request();

try {
    $router->dispatch($request);
} catch (\Throwable $e) {
    if (str_starts_with($request->getPath(), '/api/')) {
        Response::error('Server Error: ' . $e->getMessage(), 'SERVER_ERROR', 500);
    } else {
        http_response_code(500);
        echo "<!DOCTYPE html><html><body style='font-family:sans-serif;padding:30px;'>";
        echo "<h2>Terjadi Kesalahan Sistem</h2>";
        echo "<p style='color:red;'>" . htmlspecialchars($e->getMessage()) . "</p>";
        echo "<p><a href='/setup'>Klik di sini untuk Inisialisasi Database Otomatis</a></p>";
        echo "</body></html>";
    }
}
