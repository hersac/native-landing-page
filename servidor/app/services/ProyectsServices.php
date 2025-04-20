<?php

namespace app\services;

use app\config\Repository;
use app\models\ProyectEntity;

class ProyectsServices
{
    private $repository;
    private $proyects;

    public function __construct()
    {
        $this->proyects = new ProyectEntity();
        $this->repository = new Repository(get_class($this->proyects));
    }

    public function getProyects()
    {
        return json_encode($this->repository->findAll());
    }

    public function getProyect($id)
    {
        return json_encode($this->repository->findById($id));
    }

    public function createProyect($data)
    {
        return json_encode($this->repository->create($data));
    }

    public function updateProyect($id, $data)
    {
        $this->repository->update($id, $data);
        return json_encode($this->repository->findById($id));
    }

    public function deleteProyect($id)
    {
        $this->repository->delete($id);
    }
}
