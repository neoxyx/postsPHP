<?php

namespace Repositories;

use PDO;

class UserRepository
{
    private $pdo;

    public function __construct(PDO $pdo)
    {
        $this->pdo = $pdo;
    }

    /**
     * Registrar un nuevo usuario en la base de datos.
     *
     * @param string $name El nombre del usuario.
     * @param string $email El correo electrónico del usuario.
     * @param string $password La contraseña encriptada del usuario.
     * @return bool Retorna true si el registro fue exitoso, false en caso contrario.
     */
    public function register($name, $email, $password)
    {
        // Verificar si el email ya está registrado
        $stmt = $this->pdo->prepare("SELECT id FROM users WHERE email = :email");
        $stmt->execute(['email' => $email]);

        if ($stmt->fetch()) {
            throw new \Exception("El correo electrónico ya está registrado.");
        }

        // Intentar insertar el nuevo usuario
        try {
            $stmt = $this->pdo->prepare("INSERT INTO users (name, email, password) VALUES (:name, :email, :password)");
            $stmt->execute(['name' => $name, 'email' => $email, 'password' => $password]);
            return true;
        } catch (\PDOException $e) {
            throw new \Exception("Error al registrar el usuario: " . $e->getMessage());
        }
    }


    /**
     * Obtener un usuario por su correo electrónico.
     *
     * @param string $email El correo electrónico del usuario.
     * @return array|null El usuario si existe, o null si no se encuentra.
     */
    public function getUserByEmail($email)
    {
        $stmt = $this->pdo->prepare("SELECT * FROM users WHERE email = :email");
        $stmt->execute(['email' => $email]);
        return $stmt->fetch();
    }
}
