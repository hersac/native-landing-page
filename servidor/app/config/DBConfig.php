<?php

namespace app\config;

use PDO;
use PDOException;

class DBConfig
{
    private $conn;
    private $db = [
        'host' => 'localhost',
        'port' => '5432',
        'dbname' => 'portfolio',
        'username' => 'postgres',
        'password' => 'Heriberto1995**'
    ];

    public function __construct()
    {
        try {
            $this->conn = new PDO(
                "pgsql:host={$this->db['host']};port={$this->db['port']};dbname={$this->db['dbname']}",
                $this->db['username'],
                $this->db['password']
            );
            $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch (PDOException $e) {
            die("Database not connected: {$e->getMessage()}");
        }
    }

    public function getConnection()
    {
        return $this->conn;
    }
}
