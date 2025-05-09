<?php
namespace Backend\Config;

class Database {
    private $host = "localhost:8889";
    private $db_name = "propyecto_php";
    private $username = "root";
    private $password = "root";
    private $conn;

    public function connect() {
        $this->conn = null;

        try {
            $this->conn = new \PDO("mysql:host={$this->host};dbname={$this->db_name}", $this->username, $this->password);
            $this->conn->setAttribute(\PDO::ATTR_ERRMODE, \PDO::ERRMODE_EXCEPTION);
            
            // Mostrar mensaje de conexión satisfactoria
            echo "Conexión satisfactoria a la base de datos.";
            
        } catch (\PDOException $exception) {
            echo "Error de conexión: " . $exception->getMessage();
        }

        return $this->conn;
    }
}
