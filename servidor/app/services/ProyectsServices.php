<?php

namespace app\services;

use app\config\Repository;
use app\models\ProyectEntity;

class ProductsService
{
    private $repository;
    private $productos;

    public function __constructor()
    {
        $this->productos = new ProyectEntity();
        $this->repository = new Repository(get_class($this->productos));
    }

    public function getProducts()
    {
        return json_encode($this->repository->findAll());
    }
}
