<?php

namespace app\controllers;

use app\services\ProyectsServices;

class ProyectsController
{
    private $proyectsServices;

    public function __construct()
    {
        $this->proyectsServices = new ProyectsServices();
    }

    public function getProyects()
    {
        try {
            $proyects = $this->proyectsServices->getProyects();
            $this->sendResponse(200, $proyects);
        } catch (\Exception $e) {
            $this->sendError(500, "Error al obtener proyectos: " . $e->getMessage());
        }
    }

    public function getProyect($id)
    {
        try {
            if (!$id) {
                $this->sendError(400, "ID del proyecto es requerido");
                return;
            }
            
            $proyect = $this->proyectsServices->getProyect($id);
            
            if (!$proyect || $proyect === 'null') {
                $this->sendError(404, "Proyecto no encontrado");
                return;
            }
            
            $this->sendResponse(200, $proyect);
        } catch (\Exception $e) {
            $this->sendError(500, "Error al obtener el proyecto: " . $e->getMessage());
        }
    }

    public function createProyect()
    {
        try {
            $data = json_decode(file_get_contents("php://input"), true);
            
            if (!$data) {
                $this->sendError(400, "Datos del proyecto son requeridos");
                return;
            }
            
            $result = $this->proyectsServices->createProyect($data);
            $this->sendResponse(201, $result);
        } catch (\Exception $e) {
            $this->sendError(500, "Error al crear el proyecto: " . $e->getMessage());
        }
    }

    public function updateProyect($id)
    {
        try {
            if (!$id) {
                $this->sendError(400, "ID del proyecto es requerido");
                return;
            }
            
            $data = json_decode(file_get_contents("php://input"), true);
            
            if (!$data) {
                $this->sendError(400, "Datos del proyecto son requeridos");
                return;
            }
            
            $result = $this->proyectsServices->updateProyect($id, $data);
            $this->sendResponse(200, $result);
        } catch (\Exception $e) {
            $this->sendError(500, "Error al actualizar el proyecto: " . $e->getMessage());
        }
    }

    public function deleteProyect($id)
    {
        try {
            if (!$id) {
                $this->sendError(400, "ID del proyecto es requerido");
                return;
            }
            
            $this->proyectsServices->deleteProyect($id);
            $this->sendResponse(204, null);
        } catch (\Exception $e) {
            $this->sendError(500, "Error al eliminar el proyecto: " . $e->getMessage());
        }
    }

    private function sendResponse($statusCode, $data)
    {
        header('Content-Type: application/json');
        http_response_code($statusCode);
        
        if ($data !== null) {
            if (is_string($data) && $this->isJson($data)) {
                echo $data;
            } else {
                echo json_encode([
                    'status' => 'success',
                    'data' => $data
                ]);
            }
        }
        exit;
    }

    private function sendError($statusCode, $message)
    {
        header('Content-Type: application/json');
        http_response_code($statusCode);
        echo json_encode([
            'status' => 'error',
            'message' => $message
        ]);
        exit;
    }

    private function isJson($string)
    {
        json_decode($string);
        return json_last_error() === JSON_ERROR_NONE;
    }
}