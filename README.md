# Sistema de Gestión de Usuarios con Autenticación y Creación de Posts
# Este proyecto es un sistema básico de gestión de usuarios con autenticación y creación de posts. Implementado en PHP, sigue principios de arquitectura limpia y buenas prácticas de programación, lo que permite una fácil escalabilidad y mantenimiento.

# Requisitos Previos
# Servidor Web: Apache o Nginx.
# PHP: Versión 8.0.30 o superior.
# Base de Datos: MySQL o cualquier otra compatible con PDO.
# Composer: Para la gestión de dependencias de PHP.

# Configuración del Proyecto
# 1. Clonar el Repositorio
# Clona el repositorio en tu máquina local.
# bash
# Copy code
# git clone https://github.com/neoxyx/postsPHP.git
# cd postsPHP
# 2. Instalar Dependencias
# Instala las dependencias de PHP utilizando Composer.
# bash
# Copy code
# composer install
# 3. Configurar la Base de Datos
# 1.	Crea una base de datos en MySQL o en tu sistema de base de datos preferido.
# 2.	Configura el acceso a la base de datos en el archivo config/db.php:
# php
# Copy code
# <?php

# namespace Config;

# use PDO;
# use PDOException;

# class Database {
#    private $host = 'localhost';
#    private $db_name = 'nombre_de_tu_base_de_datos';
#    private $username = 'usuario';
#    private $password = 'contraseña';
#    private $conn;

#    public function getConnection() {
#        $this->conn = null;
#        try {
#            $this->conn = new PDO("mysql:host=" . $this->host . ";dbname=" . $this->db_name, #            $this->username, $this->password);
#            $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
#        } catch(PDOException $exception) {
#            echo "Error de conexión: " . $exception->getMessage();
#        }
#        return $this->conn;
#    }
# }
# 3.	Importa el esquema de la base de datos:
# sql
# Copy code
# CREATE TABLE users (
#    id INT AUTO_INCREMENT PRIMARY KEY,
#    name VARCHAR(50) NOT NULL,
#    email VARCHAR(50) UNIQUE NOT NULL,
#    password VARCHAR(255) NOT NULL,
#    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
# );

# CREATE TABLE posts (
#    id INT AUTO_INCREMENT PRIMARY KEY,
#    user_id INT NOT NULL,
#    content TEXT NOT NULL,
#    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
#    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE
# );
# 4. Configurar el Servidor Web
# •	Asegúrate de que el servidor web apunte al archivo index.php para manejar todas las solicitudes. Si usas Apache, configura un .htaccess con las reglas de reescritura necesarias.
# •	Si estás usando Nginx, puedes configurar la raíz del documento para que apunte al archivo index.php.
# Ejecución del Proyecto
# 1. Iniciar el Servidor PHP (opcional para desarrollo)
# Si deseas ejecutar el proyecto en un entorno de desarrollo, puedes usar el servidor web de desarrollo de PHP:
# bash
# Copy code
# php -S localhost:8000
# 2. Realizar Solicitudes a la API
# Una vez que el servidor esté en funcionamiento, puedes realizar solicitudes a la API:
# •	Registro de usuario: POST /api/register
# o	Datos JSON: { "name": "Nombre", "email": "email@ejemplo.com", "password": "contraseña" }
# •	Inicio de sesión: POST /api/login
# o	Datos JSON: { "email": "email@ejemplo.com", "password": "contraseña" }
# •	Crear un post: POST /api/posts
# o	Datos JSON: { "user_id": 1, "content": "Contenido del post" }
# 3. Estructura de Directorios
# •	config/: Contiene la configuración de la base de datos.
# •	controllers/: Controladores que manejan las solicitudes de la API.
# •	repositories/: Repositorios que interactúan con la base de datos.
# •	services/: Lógica de negocio.
# •	index.php: Punto de entrada principal y enrutamiento.
# Pruebas
# Se recomienda probar cada endpoint con una herramienta como Postman o cURL para asegurarse de que todo funciona correctamente.

