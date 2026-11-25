<?php
declare(strict_types=1);

namespace App\Core;

class Request
{
    private string $method;
    private string $path;
    private array $queryParams;
    private array $body;
    private array $headers;

    public function __construct()
    {
        $this->method = strtoupper($_SERVER['REQUEST_METHOD'] ?? 'GET');
        
        $uri = $_SERVER['REQUEST_URI'] ?? '/';
        $parsedUrl = parse_url($uri);
        $rawPath = $parsedUrl['path'] ?? '/';
        
        // Remove base path if run under subfolder like /ebonycraft-palu/public
        $scriptName = dirname($_SERVER['SCRIPT_NAME'] ?? '');
        if ($scriptName !== '/' && $scriptName !== '\\' && str_starts_with($rawPath, $scriptName)) {
            $rawPath = substr($rawPath, strlen($scriptName));
        }
        $this->path = '/' . trim($rawPath, '/');

        $this->queryParams = $_GET;
        $this->headers = getallheaders() ?: [];

        if ($this->method === 'POST') {
            $contentType = $_SERVER['CONTENT_TYPE'] ?? '';
            if (str_contains($contentType, 'application/json')) {
                $rawInput = file_get_contents('php://input');
                $this->body = json_decode($rawInput, true) ?: [];
            } else {
                $this->body = $_POST;
            }
        } else {
            $this->body = [];
        }
    }

    public function getMethod(): string
    {
        return $this->method;
    }

    public function getPath(): string
    {
        return $this->path;
    }

    public function getQuery(string $key, mixed $default = null): mixed
    {
        return $this->queryParams[$key] ?? $default;
    }

    public function getQueryParams(): array
    {
        return $this->queryParams;
    }

    public function getBody(): array
    {
        return $this->body;
    }

    public function input(string $key, mixed $default = null): mixed
    {
        return $this->body[$key] ?? $this->queryParams[$key] ?? $default;
    }

    public function getFilters(): array
    {
        $filters = [];
        if (!empty($this->queryParams['date_from'])) {
            $filters['date_from'] = $this->queryParams['date_from'];
        }
        if (!empty($this->queryParams['date_to'])) {
            $filters['date_to'] = $this->queryParams['date_to'];
        }
        if (!empty($this->queryParams['category_id'])) {
            $filters['category_id'] = (int)$this->queryParams['category_id'];
        }
        if (!empty($this->queryParams['channel_id'])) {
            $filters['channel_id'] = (int)$this->queryParams['channel_id'];
        }
        if (!empty($this->queryParams['region_id'])) {
            $filters['region_id'] = (int)$this->queryParams['region_id'];
        }
        return $filters;
    }
}
