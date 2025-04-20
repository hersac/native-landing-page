<?php

namespace app\routes;

use app\controllers\ProyectsController;
use app\interfaces\RoutesInterface;
use app\App;

class ProyectsRoutes implements RoutesInterface
{
    private $controller;
    private $baseRoute = '/api/proyects';

    public function __construct()
    {
        $this->controller = new ProyectsController();
    }

    public function register(App $app): void
    {

        $app->router->get($this->baseRoute . '/:id', function($id) {
            $this->controller->getProyect($id);
        });

        $app->router->put($this->baseRoute . '/:id', function($id) {
            $this->controller->updateProyect($id);
        });

        $app->router->delete($this->baseRoute . '/:id', function($id) {
            $this->controller->deleteProyect($id);
        });

        $app->router->post($this->baseRoute, function() {
            $this->controller->createProyect();
        });

        $app->router->get($this->baseRoute, function() {
            $this->controller->getProyects();
        });
    }
}