<?php

namespace Services;

use Repositories\UserRepository;

class UserService {
    private $userRepository;

    public function __construct(UserRepository $userRepository) {
        $this->userRepository = $userRepository;
    }

    /**
     * Registrar un nuevo usuario.
     *
     * @param array $data Los datos del usuario.
     * @return bool Retorna true si el registro fue exitoso, false en caso contrario.
     */
    public function registerUser(array $data) {
        // Validación básica
        if (empty($data['name']) || empty($data['email']) || empty($data['password'])) {
            throw new \Exception("Todos los campos son obligatorios.");
        }

        // Encriptar la contraseña antes de guardarla
        $hashedPassword = password_hash($data['password'], PASSWORD_DEFAULT);

        // Llamar al repositorio para guardar el usuario
        return $this->userRepository->register($data['name'], $data['email'], $hashedPassword);
    }

    /**
     * Autenticar a un usuario con su email y contraseña.
     *
     * @param string $email El correo electrónico del usuario.
     * @param string $password La contraseña del usuario.
     * @return bool Retorna true si la autenticación es exitosa, false en caso contrario.
     */
    public function authenticateUser(string $email, string $password) {
        // Verificar si el usuario existe
        $user = $this->userRepository->getUserByEmail($email);

        if ($user === null) {
            throw new \Exception("Usuario no encontrado.");
        }

        // Verificar que la contraseña coincida
        if (password_verify($password, $user['password'])) {
            return true;
        }

        throw new \Exception("Contraseña incorrecta.");
    }
}
