<?php

namespace App\Core;

class Router
{
    private array $routes = [];

    public function get(string $path, array $action): void
    {
        $this->addRoute('GET', $path, $action);
    }

    public function post(string $path, array $action): void
    {
        $this->addRoute('POST', $path, $action);
    }

    private function addRoute(string $method, string $path, array $action): void
    {
        $this->routes[] = [
            'method' => $method,
            'path'   => $path,
            'action' => $action
        ];
    }

    public function dispatch(): void
    {
        $requestMethod = $_SERVER['REQUEST_METHOD'];
        $requestUri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);

        foreach ($this->routes as $route) {
            if ($route['method'] !== $requestMethod) {
                continue;
            }

            $pattern = $this->convertPathToRegex($route['path']);
            if (preg_match($pattern, $requestUri, $matches)) {
                array_shift($matches);
                [$controller, $method] = $route['action'];

                $instance = $this->resolve($controller);
                $instance->$method(...$matches);
                return;
            }
        }

        http_response_code(404);
        echo json_encode(['error' => 'Route not found']);
    }

    private function convertPathToRegex(string $path): string
    {
        $regex = preg_replace('#\{[\w]+\}#', '([\w-]+)', $path);
        return "#^{$regex}$#";
    }

    private function resolve(string $class)
    {
        if ($class === \PDO::class) {
            return \App\Database\Connection::getInstance();
        }
        
        $reflector = new \ReflectionClass($class);
        $constructor = $reflector->getConstructor();

        if (!$constructor) {
            return new $class();
        }

        $params = $constructor->getParameters();
        $dependencies = [];

        foreach ($params as $param) {
            $type = $param->getType();
            if ($type && !$type->isBuiltin()) {
                $dependencies[] = $this->resolve($type->getName());
            } else {
                throw new \Exception("Unable to resolve the parameter {$param->getName()} in {$class}");
            }
        }

        return $reflector->newInstanceArgs($dependencies);
    }
}