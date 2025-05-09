<?php
// Mostrar errores en entorno de desarrollo
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// Requiere los archivos necesarios
require_once 'config/Database.php';
require_once 'models/Usuario.php';
require_once 'repositories/UsuarioRepository.php';
require_once 'services/UsuarioService.php';
require_once 'controllers/UsuarioController.php';
require_once 'middleware/AuthMiddleware.php';
require_once 'utils/JWT.php';

use Backend\Utils\JWTHandler;

// Conexión a la base de datos
$database = new \Backend\Config\Database();
$db = $database->connect();

// Inyección de dependencias
$usuarioRepo = new \Backend\Repositories\UsuarioRepository($db);
$usuarioService = new \Backend\Services\UsuarioService($usuarioRepo);
$usuarioController = new \Backend\Controllers\UsuarioController($usuarioService);
$authMiddleware = new \Backend\Middleware\AuthMiddleware();

// Obtener método y ruta
$method = $_SERVER['REQUEST_METHOD'];
$uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
$basePath = '/php-aplicaciones/backend/index.php';

$lastPart = str_replace($basePath, '', $uri);

// Rutas de ejemplo
if ($method === 'POST' && $lastPart  === '/create') {
    $data = json_decode(file_get_contents('php://input'), true);
    $usuarioController->create($data);
}

if ($method === 'POST' && $lastPart  === '/login') {
    $data = json_decode(file_get_contents('php://input'), true);
    $user = $usuarioService->login($data['usuario'], $data['password']);
    
    if ($user === 'bloqueado') {
        echo json_encode(['message' => 'Usuario bloqueado']);
    } elseif ($user) {
        $token = JWTHandler::create([
            'id' => $user->id,
            'usuario' => $user->usuario,
            'rol' => $user->rol
        ]);
        echo json_encode(['token' => $token]);
    } else {
        echo json_encode(['message' => 'Credenciales inválidas']);
    }
}
