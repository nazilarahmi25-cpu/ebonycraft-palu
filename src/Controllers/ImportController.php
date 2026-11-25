<?php
declare(strict_types=1);

namespace App\Controllers;

use App\Core\Auth;
use App\Core\Csrf;
use App\Core\Request;
use App\Core\Response;
use App\Services\ImportService;

class ImportController
{
    private ImportService $importService;

    public function __construct()
    {
        $this->importService = new ImportService();
    }

    public function transactions(Request $request): void
    {
        if (!Auth::check()) {
            Response::error('Akses ditolak. Silakan login sebagai admin.', 'UNAUTHORIZED', 401);
        }

        $token = $request->input('csrf_token');
        if (!Csrf::validate($token)) {
            Response::error('Token CSRF tidak valid.', 'CSRF_ERROR', 403);
        }

        if (empty($_FILES['csv_file']['tmp_name'])) {
            Response::error('File CSV wajib diunggah.', 'VALIDATION_ERROR', 400);
        }

        $file = $_FILES['csv_file'];
        if ($file['size'] > 5 * 1024 * 1024) {
            Response::error('Ukuran file melebihi batas 5 MB.', 'FILE_TOO_LARGE', 400);
        }

        try {
            $result = $this->importService->importCsv($file['tmp_name']);
            Response::json($result);
        } catch (\Throwable $e) {
            Response::error('Gagal mengimpor CSV: ' . $e->getMessage(), 'IMPORT_ERROR', 500);
        }
    }
}
