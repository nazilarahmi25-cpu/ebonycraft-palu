<?php
declare(strict_types=1);

namespace App\Controllers;

use App\Core\Request;
use App\Core\Response;
use App\Services\ChartService;

class ExportController
{
    private ChartService $chartService;

    public function __construct()
    {
        $this->chartService = new ChartService();
    }

    public function exportCsv(Request $request, string $id): void
    {
        try {
            $filters = $request->getFilters();
            $data = $this->chartService->getChartData($id, $filters);

            $filename = "ebonycraft_{$id}_" . date('Ymd_His') . ".csv";
            $headers = ['Kategori / Periode'];
            foreach ($data['series'] as $s) {
                $headers[] = $s['name'] ?? 'Nilai';
            }

            $rows = [];
            $categories = $data['categories'] ?? [];

            foreach ($categories as $idx => $cat) {
                $row = [$cat];
                foreach ($data['series'] as $s) {
                    $val = $s['data'][$idx] ?? '';
                    if (is_array($val)) {
                        $val = json_encode($val);
                    }
                    $row[] = $val;
                }
                $rows[] = $row;
            }

            Response::csv($filename, $headers, $rows);
        } catch (\Throwable $e) {
            Response::error('Gagal mengekspor CSV: ' . $e->getMessage(), 'EXPORT_ERROR', 500);
        }
    }
}
