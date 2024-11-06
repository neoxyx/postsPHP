<?php

require 'vendor/autoload.php';

// Cargar el archivo de configuración de la base de datos
require_once 'config/db.php';

use Controllers\AuthController;
use Controllers\PostController;
use Repositories\UserRepository;
use Repositories\PostRepository;
use Services\UserService;
use Services\PostService;
use Services\AuthService;

// Obtener la conexión a la base de datos
$database = new Database();
$pdo = $database->getConnection();

// Instancias de repositorios y servicios
$userRepository = new UserRepository($pdo);
$postRepository = new PostRepository($pdo);

$userService = new UserService($userRepository);
$postService = new PostService($postRepository);
$authService = new AuthService($userRepository);  // Instancia de AuthService

// Controladores
$authController = new AuthController($authService, $userService);  // Pasamos AuthService en lugar de UserService
$postController = new PostController($postService);

// Función para obtener el método HTTP y la ruta de la solicitud
$method = $_SERVER['REQUEST_METHOD'];
$request = trim($_SERVER['REQUEST_URI'], '/');

// Enrutamiento básico
switch ($method) {
    case 'POST':
        if ($request === 'api/register') {
            // Ruta para registrar un nuevo usuario
            $data = json_decode(file_get_contents('php://input'), true);
            $authController->register($data);
        } elseif ($request === 'api/login') {
            // Ruta para autenticar un usuario
            $data = json_decode(file_get_contents('php://input'), true);
            $authController->login($data);
        } elseif ($request === 'api/posts') {
            // Ruta para crear un nuevo post (solo autenticado)
            $data = json_decode(file_get_contents('php://input'), true);
            $postController->createPost($data);
        }
        break;

    case 'GET':
        if (preg_match('/^api\/posts\/(\d+)$/', $request, $matches)) {
            // Ruta para listar todos los posts de una categoría
            $categoryId = (int) $matches[1];
            $postController->getPostsByCategory($categoryId);
        }
        break;

    default:
        // Responder con 404 para solicitudes no manejadas
        http_response_code(404);
        echo json_encode(['message' => 'Ruta no encontrada']);
        break;
}