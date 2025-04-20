<?php

namespace app\config;

use app\App;
use app\interfaces\RoutesInterface;

class RouteRegistrar {
    private $routesDirectory;
    private $routesNamespace;
    
    public function __construct(string $routesDirectory = 'app/routes', string $routesNamespace = 'app\\routes\\') {
        $this->routesDirectory = $routesDirectory;
        $this->routesNamespace = $routesNamespace;
    }
    
    public function registerRoutes(App $app): void {
        $routeFiles = glob($this->routesDirectory . '/*.php');
        
        foreach ($routeFiles as $routeFile) {
            $filename = pathinfo($routeFile, PATHINFO_FILENAME);
            
            $className = $this->routesNamespace . $filename;
            
            if (class_exists($className)) {
                $reflection = new \ReflectionClass($className);
                
                if ($reflection->implementsInterface(RoutesInterface::class) && !$reflection->isAbstract()) {
                    $routeInstance = new $className();
                    $routeInstance->register($app);
                }
            }
        }
    }
}