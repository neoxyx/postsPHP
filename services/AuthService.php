<?php

namespace Services;

use Repositories\UserRepository;

class AuthService {
    private $userRepository;

    public function __construct(UserRepository $userRepository) {
        $this->userRepository = $userRepository;
    }

    /**
     * Verifica las credenciales del usuario.
     *
     * @param string $email El correo electrónico del usuario.
     * @param string $password La contraseña del usuario.
     * @return bool Retorna true si la autenticación es exitosa, false en caso contrario.
     */
    public function authenticate(string $email, string $password) {
        // Buscar al usuario en la base de datos
        $user = $this->userRepository->getUserByEmail($email);

        if ($user === null) {
            throw new \Exception("Usuario no encontrado.");
        }

        // Verificar si la contraseña es correcta
        if (password_verify($password, $user['password'])) {
            return true;
        }

        throw new \Exception("Contraseña incorrecta.");
    }
}
