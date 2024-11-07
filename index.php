<?php

require 'vendor/autoload.php';
require_once 'config/db.php';

use Config\Database;
use Controllers\AuthController;
use Controllers\PostController;
use Repositories\UserRepository;
use Repositories\PostRepository;
use Services\UserService;
use Services\PostService;
use Services\AuthService;

$database = new Database();
$pdo = $database->getConnection();

$userRepository = new UserRepository($pdo);
$postRepository = new PostRepository($pdo);

$userService = new UserService($userRepository);
$postService = new PostService($postRepository);
$authService = new AuthService($userRepository);

$authController = new AuthController($authService, $userService);
$postController = new PostController($postService);

$method = $_SERVER['REQUEST_METHOD'];
$request = trim($_SERVER['REQUEST_URI'], '/');

switch ($method) {
    case 'POST':
        $data = json_decode(file_get_contents('php://input'), true);
        if ($request === 'api/register') {
            $authController->register($data);
        } elseif ($request === 'api/login') {
            $authController->login($data);
        } elseif ($request === 'api/posts') {
            $postController->createPost($data);
        }
        break;

    default:
        http_response_code(404);
        echo json_encode(['message' => 'Ruta no encontrada']);
        break;
}
