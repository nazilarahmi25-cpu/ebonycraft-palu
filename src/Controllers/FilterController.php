<?php
declare(strict_types=1);

namespace App\Controllers;

use App\Core\Request;
use App\Core\Response;
use App\Repositories\SalesRepository;

class FilterController
{
    private SalesRepository $salesRepo;

    public function __construct()
    {
        $this->salesRepo = new SalesRepository();
    }

    public function index(Request $request): void
    {
        try {
            $options = $this->salesRepo->getFilterOptions();
            Response::json([
                'status'  => 'success',
                'filters' => $options,
            ]);
        } catch (\Throwable $e) {
            Response::error('Gagal memuat filter: ' . $e->getMessage(), 'SERVER_ERROR', 500);
        }
    }
}
