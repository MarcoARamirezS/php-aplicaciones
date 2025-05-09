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

    public function getByUsername($usuario) {
        $sql = "SELECT * FROM usuarios WHERE usuario = :usuario";
        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(':usuario', $usuario);
        $stmt->execute();
    
        $data = $stmt->fetch(PDO::FETCH_ASSOC);
    
        if (!$data) {
            return null;
        }
    
        return new Usuario(
            $data['id'],
            $data['nombre'],
            $data['apaterno'],
            $data['amaterno'],
            $data['direccion'],
            $data['telefono'],
            $data['ciudad'],
            $data['estado'],
            $data['usuario'],
            $data['password'],
            $data['rol']
        );
    }    

    public function update(Usuario $usuario) {
        // Obtener la contraseña actual del usuario para saber si fue modificada
        $sql = "SELECT password FROM usuarios WHERE id = :id";
        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(':id', $usuario->id);
        $stmt->execute();
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        $passwordActual = $result['password'] ?? '';

        // Verificar si la nueva contraseña es diferente a la actual
        // Si lo es, la encriptamos
        if (!password_verify($usuario->password, $passwordActual)) {
            $usuario->password = password_hash($usuario->password, PASSWORD_DEFAULT);
        }

        // Ahora actualizamos
        $sql = "UPDATE usuarios SET 
                    nombre = :nombre, 
                    apaterno = :apaterno, 
                    amaterno = :amaterno, 
                    direccion = :direccion,
                    telefono = :telefono, 
                    ciudad = :ciudad, 
                    estado = :estado, 
                    usuario = :usuario, 
                    password = :password, 
                    rol = :rol 
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
