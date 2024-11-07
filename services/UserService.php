<?php

namespace Services;

use Repositories\UserRepository;

class UserService {
    private $userRepository;

    public function __construct(UserRepository $userRepository) {
        $this->userRepository = $userRepository;
    }

    public function registerUser($data) {
        $hashedPassword = password_hash($data['password'], PASSWORD_BCRYPT);
        return $this->userRepository->register($data['name'], $data['email'], $hashedPassword);
    }
}
