<?php

require 'vendor/autoload.php';

use Controllers\AuthController;
use Controllers\PostController;
use Repositories\UserRepository;
use Repositories\PostRepository;
use Services\UserService;
use Services\PostService;

// Configuración de la conexión a la base de datos (modificar según sea necesario)
$dsn = 'mysql:host=localhost;dbname=nombre_de_tu_base_de_datos;charset=utf8';
$username = 'tu_usuario';
$password = 'tu_contraseña';
$options = [
    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
];

try {
    $pdo = new PDO($dsn, $username, $password, $options);
} catch (PDOException $e) {
    die('Error al conectar con la base de datos: ' . $e->getMessage());
}

// Instancias de repositorios y servicios
$userRepository = new UserRepository($pdo);
$postRepository = new PostRepository($pdo);

$userService = new UserService($userRepository);
$postService = new PostService($postRepository);

// Controladores
$authController = new AuthController($userService);
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
            $categoryId = (int)$matches[1];
            $postController->getPostsByCategory($categoryId);
        }
        break;

    default:
        // Responder con 404 para solicitudes no manejadas
        http_response_code(404);
        echo json_encode(['message' => 'Ruta no encontrada']);
        break;
}

?>
