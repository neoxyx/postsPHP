<?php

namespace Controllers;

use Services\AuthService;
use Services\UserService;

class AuthController {
    private $authService;
    private $userService;

    public function __construct(AuthService $authService, UserService $userService) {
        $this->authService = $authService;
        $this->userService = $userService;
    }

    public function register($data) {
        try {
            $this->userService->registerUser($data);
            echo json_encode(["message" => "Usuario registrado exitosamente."]);
        } catch (\Exception $e) {
            http_response_code(400);
            echo json_encode(["error" => $e->getMessage()]);
        }
    }

    public function login($data) {
        try {
            $this->authService->authenticate($data['email'], $data['password']);
            echo json_encode(["message" => "Inicio de sesión exitoso."]);
        } catch (\Exception $e) {
            http_response_code(400);
            echo json_encode(["error" => $e->getMessage()]);
        }
    }
}
