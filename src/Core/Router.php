<?php
declare(strict_types=1);

namespace App\Core;

class Router
{
    private array $routes = [];

    public function get(string $path, callable|array $handler): void
    {
        $this->addRoute('GET', $path, $handler);
    }

    public function post(string $path, callable|array $handler): void
    {
        $this->addRoute('POST', $path, $handler);
    }

    private function addRoute(string $method, string $path, callable|array $handler): void
    {
        // Convert pattern like /charts/{id} to regex
        $pattern = preg_replace('/\{([a-zA-Z0-9_]+)\}/', '(?P<$1>[^/]+)', $path);
        $pattern = '#^' . $pattern . '$#';

        $this->routes[] = [
            'method'  => $method,
            'pattern' => $pattern,
            'handler' => $handler,
        ];
    }

    public function dispatch(Request $request): void
    {
        $reqMethod = $request->getMethod();
        $reqPath   = $request->getPath();

        foreach ($this->routes as $route) {
            if ($route['method'] !== $reqMethod) {
                continue;
            }

            if (preg_match($route['pattern'], $reqPath, $matches)) {
                $params = array_filter($matches, 'is_string', ARRAY_FILTER_USE_KEY);
                $handler = $route['handler'];

                if (is_array($handler)) {
                    [$class, $method] = $handler;
                    $controller = new $class();
                    $controller->$method($request, ...$params);
                    return;
                }

                $handler($request, ...$params);
                return;
            }
        }

        // Route not found
        if (str_starts_with($reqPath, '/api/')) {
            Response::error('Endpoint not found: ' . $reqPath, 'NOT_FOUND', 404);
        } else {
            http_response_code(404);
            echo "<h1>404 Halaman Tidak Ditemukan</h1><p>URL: " . htmlspecialchars($reqPath) . "</p>";
        }
    }
}
