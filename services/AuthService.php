<?php

namespace Services;

use Repositories\UserRepository;

class AuthService {
    private $userRepository;

    public function __construct(UserRepository $userRepository) {
        $this->userRepository = $userRepository;
    }

    public function authenticate($email, $password) {
        $user = $this->userRepository->getUserByEmail($email);
        if (!$user || !password_verify($password, $user['password'])) {
            throw new \Exception("Credenciales inválidas");
        }
        return $user;
    }
}
