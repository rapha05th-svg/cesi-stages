<?php

final class Router
{
    private array $routes = [];
    private string $basePath;

    public function __construct(string $basePath = '')
    {
        $this->basePath = rtrim($basePath, '/');
    }

    public function get(string $path, array $handler): void
    {
        $this->addRoute('GET', $path, $handler);
    }

    public function post(string $path, array $handler): void
    {
        $this->addRoute('POST', $path, $handler);
    }

    private function addRoute(string $method, string $path, array $handler): void
    {
        $normalizedPath = $this->normalizePath($path);
        $this->routes[$method][$normalizedPath] = $handler;
    }

    public function dispatch(string $method, string $uri): void
    {
        $normalizedUri = $this->normalizePath($uri);

        if (!isset($this->routes[$method][$normalizedUri])) {
            http_response_code(404);
            $page404 = __DIR__ . '/../views/errors/404.php';
            if (file_exists($page404)) {
                require $page404;
            } else {
                echo '<h1>404 — Page introuvable</h1>';
            }
            return;
        }

        [$controllerClass, $action] = $this->routes[$method][$normalizedUri];

        if (!class_exists($controllerClass)) {
            http_response_code(500);
            echo 'Controller not found';
            return;
        }

        $controller = new $controllerClass();

        if (!method_exists($controller, $action)) {
            http_response_code(500);
            echo 'Action not found';
            return;
        }

        $controller->$action();
    }

    private function normalizePath(string $path): string
    {
        $path = strtok($path, '?');

        if ($this->basePath !== '' && str_starts_with($path, $this->basePath)) {
            $path = substr($path, strlen($this->basePath));
        }

        if ($path === '' || $path === false) {
            return '/';
        }

        $path = '/' . trim($path, '/');

        return $path === '//' ? '/' : $path;
    }
}