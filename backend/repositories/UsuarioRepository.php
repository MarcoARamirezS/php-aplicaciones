<?php
namespace Backend\Repositories;

use Backend\Models\Usuario;
use PDO;

class UsuarioRepository {
    private $conn;

    public function __construct(PDO $conn) {
        $this->conn = $conn;
    }

    public function create(Usuario $usuario) {
        $sql = "INSERT INTO usuarios (nombre, apaterno, amaterno, direccion, telefono, ciudad, estado, usuario, password, rol) 
                VALUES (:nombre, :apaterno, :amaterno, :direccion, :telefono, :ciudad, :estado, :usuario, :password, :rol)";
        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(':nombre', $usuario->nombre);
        $stmt->bindParam(':apaterno', $usuario->apaterno);
        $stmt->bindParam(':amaterno', $usuario->amaterno);
        $stmt->bindParam(':direccion', $usuario->direccion);
        $stmt->bindParam(':telefono', $usuario->telefono);
        $stmt->bindParam(':ciudad', $usuario->ciudad);
        $stmt->bindParam(':estado', $usuario->estado);
        $stmt->bindParam(':usuario', $usuario->usuario);
        $stmt->bindParam(':password', $usuario->password);
        $stmt->bindParam(':rol', $usuario->rol);
        
        return $stmt->execute();
    }

    public function getAll() {
        $sql = "SELECT * FROM usuarios";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getById($id) {
        $sql = "SELECT * FROM usuarios WHERE id = :id";
        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(':id', $id);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function update(Usuario $usuario) {
        $sql = "UPDATE usuarios SET nombre = :nombre, apaterno = :apaterno, amaterno = :amaterno, direccion = :direccion,
                telefono = :telefono, ciudad = :ciudad, estado = :estado, usuario = :usuario, password = :password, rol = :rol 
                WHERE id = :id";
        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(':nombre', $usuario->nombre);
        $stmt->bindParam(':apaterno', $usuario->apaterno);
        $stmt->bindParam(':amaterno', $usuario->amaterno);
        $stmt->bindParam(':direccion', $usuario->direccion);
        $stmt->bindParam(':telefono', $usuario->telefono);
        $stmt->bindParam(':ciudad', $usuario->ciudad);
        $stmt->bindParam(':estado', $usuario->estado);
        $stmt->bindParam(':usuario', $usuario->usuario);
        $stmt->bindParam(':password', $usuario->password);
        $stmt->bindParam(':rol', $usuario->rol);
        $stmt->bindParam(':id', $usuario->id);
        return $stmt->execute();
    }

    public function delete($id) {
        $sql = "DELETE FROM usuarios WHERE id = :id";
        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(':id', $id);
        return $stmt->execute();
    }
}
