<?php
declare(strict_types=1);

namespace App\Core;

class View
{
    private static string $viewsDir = __DIR__ . '/../../resources/views/';

    public static function render(string $template, array $data = [], ?string $layout = 'layout'): void
    {
        Response::setSecurityHeaders();

        // Extract variables for view
        extract($data);

        // Helper escape function
        $e = fn(mixed $val): string => htmlspecialchars((string)$val, ENT_QUOTES, 'UTF-8');

        $viewFile = self::$viewsDir . ltrim($template, '/') . '.php';
        if (!file_exists($viewFile)) {
            http_response_code(500);
            echo "View [{$template}] not found.";
            exit;
        }

        ob_start();
        include $viewFile;
        $content = ob_get_clean();

        if ($layout !== null) {
            $layoutFile = self::$viewsDir . ltrim($layout, '/') . '.php';
            if (file_exists($layoutFile)) {
                include $layoutFile;
                exit;
            }
        }

        echo $content;
        exit;
    }
}
