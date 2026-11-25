<?php
declare(strict_types=1);

namespace App\Controllers;

use App\Core\Request;
use App\Core\Response;
use App\Services\KpiService;
use App\Services\InsightService;

class KpiController
{
    private KpiService $kpiService;
    private InsightService $insightService;

    public function __construct()
    {
        $this->kpiService = new KpiService();
        $this->insightService = new InsightService();
    }

    public function kpi(Request $request): void
    {
        $page = (string)$request->getQuery('page', 'ringkasan');
        $filters = $request->getFilters();
        $cards = $this->kpiService->getKpiForPage($page, $filters);

        Response::json([
            'page'  => $page,
            'cards' => $cards,
        ]);
    }

    public function insights(Request $request): void
    {
        $page = (string)$request->getQuery('page', 'ringkasan');
        $filters = $request->getFilters();
        $insights = $this->insightService->getInsights($page, $filters);

        Response::json([
            'page'     => $page,
            'insights' => $insights,
        ]);
    }
}
