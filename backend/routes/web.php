<?php
use Backend\Controllers\UsuarioController;
use Backend\Services\UsuarioService;
use Backend\Repositories\UsuarioRepository;
use Backend\Config\Database;

$database = new Database();
$db = $database->connect();
$usuarioRepo = new UsuarioRepository($db);
$usuarioService = new UsuarioService($usuarioRepo);
$usuarioController = new UsuarioController($usuarioService);

$router->post('/login', [$usuarioController, 'login']);
$router->post('/create', [$usuarioController, 'create']);
$router->get('/usuarios', [$usuarioController, 'getAll']);
$router->get('/usuario/{id}', [$usuarioController, 'getById']);
$router->put('/usuario/{id}', [$usuarioController, 'update']);
$router->delete('/usuario/{id}', [$usuarioController, 'delete']);
