<?php

namespace app;

use app\config\Router;
use app\config\RouteRegistrar;

class App
{
    public $router;
    private $routeRegistrar;

    public function __construct()
    {
        $this->router = new Router();
        $this->routeRegistrar = new RouteRegistrar();
        $this->setupCORS();
    }
    
    private function setupCORS()
    {
        if (isset($_SERVER['HTTP_ORIGIN'])) {
            header("Access-Control-Allow-Origin: {$_SERVER['HTTP_ORIGIN']}");
            header('Access-Control-Allow-Credentials: true');
        } else {
            header('Access-Control-Allow-Origin: *');
        }
        
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
    
    public function registerRoutes()
    {
        $this->routeRegistrar->registerRoutes($this);
        return $this;
    }
    
    public function run()
    {
        $method = $_SERVER['REQUEST_METHOD'];
        $uri = $_SERVER['REQUEST_URI'];
        
        $basePath = dirname($_SERVER['SCRIPT_NAME']);
        if ($basePath !== '/' && $basePath !== '\\') {
            $uri = substr($uri, strlen($basePath));
        }
        
        $this->router->resolve($method, $uri);
    }
}
