<?php
namespace Controllers;

use Services\AuthService;

class AuthController {
    private $authService;

    public function __construct(AuthService $authService) {
        $this->authService = $authService;
    }

    /**
     * Handle user registration
     */
    public function register($request) {
        $data = [
            'name' => $request['name'],
            'email' => $request['email'],
            'password' => $request['password']
        ];

        $result = $this->authService->register($data);

        if ($result) {
            return [
                'status' => 'success',
                'message' => 'User registered successfully.'
            ];
        } else {
            return [
                'status' => 'error',
                'message' => 'User registration failed.'
            ];
        }
    }

    /**
     * Handle user login
     */
    public function login($request) {
        $email = $request['email'];
        $password = $request['password'];

        $token = $this->authService->login($email, $password);

        if ($token) {
            return [
                'status' => 'success',
                'message' => 'Login successful.',
                'token' => $token
            ];
        } else {
            return [
                'status' => 'error',
                'message' => 'Invalid credentials.'
            ];
        }
    }
}
?>
