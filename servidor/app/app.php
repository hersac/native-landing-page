<?php

namespace app;

use app\routes\ProyectsRoutes;

/**
 * Simple Router class for handling HTTP requests
 */
class Router
{
    private $routes = [];

    /**
     * Register a GET route
     * 
     * @param string $path Route path
     * @param callable $callback Function to execute
     * @return void
     */
    public function get($path, $callback)
    {
        $this->addRoute('GET', $path, $callback);
    }

    /**
     * Register a POST route
     * 
     * @param string $path Route path
     * @param callable $callback Function to execute
     * @return void
     */
    public function post($path, $callback)
    {
        $this->addRoute('POST', $path, $callback);
    }

    /**
     * Register a PUT route
     * 
     * @param string $path Route path
     * @param callable $callback Function to execute
     * @return void
     */
    public function put($path, $callback)
    {
        $this->addRoute('PUT', $path, $callback);
    }

    /**
     * Register a DELETE route
     * 
     * @param string $path Route path
     * @param callable $callback Function to execute
     * @return void
     */
    public function delete($path, $callback)
    {
        $this->addRoute('DELETE', $path, $callback);
    }

    /**
     * Add a route to the routes array
     * 
     * @param string $method HTTP method
     * @param string $path Route path
     * @param callable $callback Function to execute
     * @return void
     */
    private function addRoute($method, $path, $callback)
    {
        // Convert path params like :id to a regex pattern
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

    /**
     * Resolve the current route
     * 
     * @param string $method HTTP method
     * @param string $uri Request URI
     * @return void
     */
    public function resolve($method, $uri)
    {
        // Remove query string from URI if present
        $uri = explode('?', $uri)[0];
        
        foreach ($this->routes as $route) {
            if ($route['method'] === $method && preg_match($route['pattern'], $uri, $matches)) {
                // Remove the first match (full match)
                array_shift($matches);
                
                // Call the callback with the matches as parameters
                call_user_func_array($route['callback'], $matches);
                return;
            }
        }
        
        // If no route matches, return 404
        header('Content-Type: application/json');
        http_response_code(404);
        echo json_encode([
            'status' => 'error',
            'message' => 'Route not found'
        ]);
    }
}

class App
{
    public $router;
    
    /**
     * Initialize the application
     */
    public function __construct()
    {
        $this->router = new Router();
        
        // Enable CORS
        $this->setupCORS();
    }
    
    /**
     * Setup CORS headers
     */
    private function setupCORS()
    {
        // Allow from any origin
        if (isset($_SERVER['HTTP_ORIGIN'])) {
            header("Access-Control-Allow-Origin: {$_SERVER['HTTP_ORIGIN']}");
            header('Access-Control-Allow-Credentials: true');
        } else {
            header('Access-Control-Allow-Origin: *');
        }
        
        // Access-Control headers are received during OPTIONS requests
        if ($_SERVER['REQUEST_METHOD'] == 'OPTIONS') {
            if (isset($_SERVER['HTTP_ACCESS_CONTROL_REQUEST_METHOD'])) {
                header("Access-Control-Allow-Methods: GET, POST, PUT, DELETE, OPTIONS");
            }
            
            if (isset($_SERVER['HTTP_ACCESS_CONTROL_REQUEST_HEADERS'])) {
                header("Access-Control-Allow-Headers: {$_SERVER['HTTP_ACCESS_CONTROL_REQUEST_HEADERS']}");
            }
            
            exit(0);
        }
    }
    
    /**
     * Run the application
     */
    public function run()
    {
        $method = $_SERVER['REQUEST_METHOD'];
        $uri = $_SERVER['REQUEST_URI'];
        
        // Remove base path if needed
        $basePath = dirname($_SERVER['SCRIPT_NAME']);
        if ($basePath !== '/' && $basePath !== '\\') {
            $uri = substr($uri, strlen($basePath));
        }
        
        $this->router->resolve($method, $uri);
    }
}

// Create app instance
$app = new App();

// Register routes
$proyectsRoutes = new ProyectsRoutes();
$proyectsRoutes->register($app);

// Run the application only if this file is included from index.php
if (basename($_SERVER['SCRIPT_FILENAME']) !== basename(__FILE__)) {
    $app->run();
}
