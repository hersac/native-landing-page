<?php

namespace app\routes;

use app\controllers\ProyectsController;

class ProyectsRoutes
{
    private $controller;
    private $baseRoute = '/api/proyects';

    public function __construct()
    {
        $this->controller = new ProyectsController();
    }

    public function register($app)
    {
        $app->router->get($this->baseRoute, function() {
            $this->controller->getProyects();
        });

        $app->router->get($this->baseRoute . '/:id', function($id) {
            $this->controller->getProyect($id);
        });

        $app->router->post($this->baseRoute, function() {
            $this->controller->createProyect();
        });

        $app->router->put($this->baseRoute . '/:id', function($id) {
            $this->controller->updateProyect($id);
        });

        $app->router->delete($this->baseRoute . '/:id', function($id) {
            $this->controller->deleteProyect($id);
        });
    }
}