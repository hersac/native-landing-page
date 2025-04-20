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
        $projects = $this->repository->findAll();

        foreach ($projects as &$project) {
            if (isset($project['lenguajes']) && is_string($project['lenguajes'])) {
                $project['lenguajes'] = $this->stringToArray($project['lenguajes']);
            }
            if (isset($project['etiquetas']) && is_string($project['etiquetas'])) {
                $project['etiquetas'] = $this->stringToArray($project['etiquetas']);
            }
        }
        return json_encode($projects);
    }

    public function getProyect($id)
    {
        $project = $this->repository->findById($id);

        foreach ($project as &$p) {
            if (isset($p['lenguajes']) && is_string($p['lenguajes'])) {
                $p['lenguajes'] = $this->stringToArray($p['lenguajes']);
            }
            if (isset($p['etiquetas']) && is_string($p['etiquetas'])) {
                $p['etiquetas'] = $this->stringToArray($p['etiquetas']);
            }
        }
        return json_encode($project);
    }

    public function createProyect($data)
    {
        if (isset($data['lenguajes'])) {
            $data['lenguajes'] = $this->arrayToString($data['lenguajes']);
        }
        if (isset($data['etiquetas'])) {
            $data['etiquetas'] = $this->arrayToString($data['etiquetas']);
        }
        
        $result = $this->repository->save($data);
        
        foreach ($result as &$item) {
            if (isset($item['lenguajes']) && is_string($item['lenguajes'])) {
                $item['lenguajes'] = $this->stringToArray($item['lenguajes']);
            }
            if (isset($item['etiquetas']) && is_string($item['etiquetas'])) {
                $item['etiquetas'] = $this->stringToArray($item['etiquetas']);
            }
        }
        
        return json_encode($result);
    }

    public function updateProyect($id, $data)
    {
        if (isset($data['lenguajes'])) {
            $data['lenguajes'] = $this->arrayToString($data['lenguajes']);
        }
        if (isset($data['etiquetas'])) {
            $data['etiquetas'] = $this->arrayToString($data['etiquetas']);
        }
        
        $this->repository->update($id, $data);
        
        $result = $this->repository->findById($id);

        foreach ($result as &$item) {
            if (isset($item['lenguajes']) && is_string($item['lenguajes'])) {
                $item['lenguajes'] = $this->stringToArray($item['lenguajes']);
            }
            if (isset($item['etiquetas']) && is_string($item['etiquetas'])) {
                $item['etiquetas'] = $this->stringToArray($item['etiquetas']);
            }
        }
        
        return json_encode($result);
    }

    public function deleteProyect($id)
    {
        $this->repository->delete($id);
    }
    
    private function stringToArray($string) 
    {
        if (is_array($string)) {
            return $string;
        }
        
        $string = str_replace(["'", '"', '[', ']', ' '], '', $string);
        return explode(',', $string);
    }
    
    private function arrayToString($array) 
    {
        if (is_string($array)) {
            return $array;
        }
        
        if (is_array($array)) {
            return json_encode($array);
        }
        
        return (string) $array;
    }
}
