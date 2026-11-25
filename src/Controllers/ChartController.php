<?php
declare(strict_types=1);

namespace App\Controllers;

use App\Core\Request;
use App\Core\Response;
use App\Services\ChartService;

class ChartController
{
    private ChartService $chartService;

    public function __construct()
    {
        $this->chartService = new ChartService();
    }

    public function show(Request $request, string $id): void
    {
        try {
            $filters = $request->getFilters();
            $data = $this->chartService->getChartData($id, $filters);
            Response::json($data);
        } catch (\InvalidArgumentException $e) {
            Response::error($e->getMessage(), 'NOT_FOUND', 404);
        } catch (\Throwable $e) {
            Response::error('Gagal mengambil data chart: ' . $e->getMessage(), 'SERVER_ERROR', 500);
        }
    }
}
