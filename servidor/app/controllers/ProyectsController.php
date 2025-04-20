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

    /**
     * Get all projects
     * 
     * @return void
     */
    public function getProyects()
    {
        try {
            $proyects = $this->proyectsServices->getProyects();
            $this->sendResponse(200, $proyects);
        } catch (\Exception $e) {
            $this->sendError(500, "Error al obtener proyectos: " . $e->getMessage());
        }
    }

    /**
     * Get a project by ID
     * 
     * @param int $id Project ID
     * @return void
     */
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

    /**
     * Create a new project
     * 
     * @param array $data Project data
     * @return void
     */
    public function createProyect()
    {
        try {
            // Obtener datos del cuerpo de la solicitud
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

    /**
     * Update an existing project
     * 
     * @param int $id Project ID
     * @return void
     */
    public function updateProyect($id)
    {
        try {
            if (!$id) {
                $this->sendError(400, "ID del proyecto es requerido");
                return;
            }
            
            // Obtener datos del cuerpo de la solicitud
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

    /**
     * Delete a project
     * 
     * @param int $id Project ID
     * @return void
     */
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

    /**
     * Send a success response
     * 
     * @param int $statusCode HTTP status code
     * @param mixed $data Response data
     * @return void
     */
    private function sendResponse($statusCode, $data)
    {
        header('Content-Type: application/json');
        http_response_code($statusCode);
        
        if ($data !== null) {
            // Si los datos ya son una cadena JSON, los enviamos tal cual
            if (is_string($data) && $this->isJson($data)) {
                echo $data;
            } else {
                // Si no, los codificamos a JSON
                echo json_encode([
                    'status' => 'success',
                    'data' => $data
                ]);
            }
        }
        exit;
    }

    /**
     * Send an error response
     * 
     * @param int $statusCode HTTP status code
     * @param string $message Error message
     * @return void
     */
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

    /**
     * Check if string is valid JSON
     * 
     * @param string $string String to check
     * @return bool
     */
    private function isJson($string)
    {
        json_decode($string);
        return json_last_error() === JSON_ERROR_NONE;
    }
}