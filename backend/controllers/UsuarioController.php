<?php
namespace Backend\Controllers;

use Backend\Services\UsuarioService;

class UsuarioController {
    private UsuarioService $service;

    public function __construct(UsuarioService $service) {
        $this->service = $service;
    }

    public function login($data) {
        $respuesta = $this->service->login($data->usuario, $data->password);
        echo json_encode($respuesta);
    }

    public function create($data) {
        $usuario = new Usuario(null, $data->nombre, $data->apaterno, $data->amaterno, $data->direccion, $data->telefono, $data->ciudad, $data->estado, $data->usuario, $data->password, $data->rol);
        $respuesta = $this->service->create($usuario);
        echo json_encode($respuesta);
    }

    public function getAll() {
        echo json_encode($this->service->getAll());
    }

    public function getById($id) {
        $usuario = $this->service->getById($id);
        echo json_encode($usuario);
    }

    public function update($id, $data) {
        $usuario = new Usuario($id, $data->nombre, $data->apaterno, $data->amaterno, $data->direccion, $data->telefono, $data->ciudad, $data->estado, $data->usuario, $data->password, $data->rol);
        $respuesta = $this->service->update($usuario);
        echo json_encode($respuesta);
    }

    public function delete($id) {
        $respuesta = $this->service->delete($id);
        echo json_encode($respuesta);
    }
}
