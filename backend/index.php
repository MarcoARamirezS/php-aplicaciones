<?php
require_once 'config/Database.php';
require_once 'models/Usuario.php';
require_once 'repositories/UsuarioRepository.php';
require_once 'services/UsuarioService.php';
require_once 'controllers/UsuarioController.php';
require_once 'middleware/AuthMiddleware.php';
require_once 'utils/JWT.php';

$database = new \Backend\Config\Database();
$db = $database->connect();
$usuarioRepo = new \Backend\Repositories\UsuarioRepository($db);
$usuarioService = new \Backend\Services\UsuarioService($usuarioRepo);
$usuarioController = new \Backend\Controllers\UsuarioController($usuarioService);
$authMiddleware = new \Backend\Middleware\AuthMiddleware();

$method = $_SERVER['REQUEST_METHOD'];
$uri = $_SERVER['REQUEST_URI'];

// Aquí irían las rutas y el manejo de cada una
if ($method === 'POST' && $uri === '/create') {
    // Código para manejar la creación de usuario
}
