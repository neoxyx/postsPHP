<?php
namespace Services;

use Models\User;
use Repositories\UserRepository;

class AuthService {
    private $userRepo;

    public function __construct(UserRepository $userRepo) {
        $this->userRepo = $userRepo;
    }

    public function register($data) {
        // Validación y encriptación de contraseña
        $data['password'] = password_hash($data['password'], PASSWORD_BCRYPT);
        return $this->userRepo->save($data);
    }

    public function login($email, $password) {
        $user = $this->userRepo->findByEmail($email);
        if ($user && password_verify($password, $user['password'])) {
            return bin2hex(random_bytes(16)); // Token simple
        }
        return null;
    }
}
?>
