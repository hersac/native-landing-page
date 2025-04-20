<?php

namespace app\config;

class Router
{
    private $routes = [];

    public function get($path, $callback)
    {
        $this->addRoute('GET', $path, $callback);
    }

    public function post($path, $callback)
    {
        $this->addRoute('POST', $path, $callback);
    }

    public function put($path, $callback)
    {
        $this->addRoute('PUT', $path, $callback);
    }

    public function delete($path, $callback)
    {
        $this->addRoute('DELETE', $path, $callback);
    }

    private function addRoute($method, $path, $callback)
    {
        $pattern = preg_replace('/:[a-zA-Z0-9]+/', '([^/]+)', $path);
        $pattern = str_replace('/', '\/', $pattern);
        $pattern = '/^' . $pattern . '$/';

        $this->routes[] = [
            'method' => $method,
            'path' => $path,
            'pattern' => $pattern,
            'callback' => $callback
        ];
    }

    public function resolve($method, $uri)
    {
        $uri = explode('?', $uri)[0];
        
        foreach ($this->routes as $route) {
            if ($route['method'] === $method && preg_match($route['pattern'], $uri, $matches)) {
                array_shift($matches);
                
                call_user_func_array($route['callback'], $matches);
                return;
            }
        }

        header('Content-Type: application/json');
        http_response_code(404);
        echo json_encode([
            'status' => 'error',
            'message' => 'Route not found'
        ]);
    }
}