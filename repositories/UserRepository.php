<?php

namespace Repositories;

use PDO;

class UserRepository {
    private $db;

    public function __construct(PDO $db) {
        $this->db = $db;
    }

    /**
     * Registrar un nuevo usuario
     * @param array $data
     * @return bool
     */
    public function register(array $data): bool {
        $query = "INSERT INTO users (name, email, password) VALUES (:name, :email, :password)";
        $stmt = $this->db->prepare($query);
        
        // Ejecuta la consulta con los datos proporcionados
        return $stmt->execute([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => password_hash($data['password'], PASSWORD_BCRYPT)  // Encriptar la contraseña
        ]);
    }

    /**
     * Autenticar usuario por email y password
     * @param string $email
     * @param string $password
     * @return array|null
     */
    public function authenticate(string $email, string $password): ?array {
        $query = "SELECT * FROM users WHERE email = :email";
        $stmt = $this->db->prepare($query);
        $stmt->execute(['email' => $email]);
        
        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        // Verificar si el usuario existe y si la contraseña es válida
        if ($user && password_verify($password, $user['password'])) {
            return $user;  // Autenticación exitosa, devolver datos del usuario
        }
        
        return null;  // Autenticación fallida
    }

    /**
     * Verificar si un email ya está registrado
     * @param string $email
     * @return bool
     */
    public function isEmailRegistered(string $email): bool {
        $query = "SELECT COUNT(*) FROM users WHERE email = :email";
        $stmt = $this->db->prepare($query);
        $stmt->execute(['email' => $email]);
        
        return $stmt->fetchColumn() > 0;  // Retorna true si el email ya existe
    }
}
