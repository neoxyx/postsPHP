<?php

namespace Repositories;

use PDO;

class PostRepository {
    private $pdo;

    public function __construct(PDO $pdo) {
        $this->pdo = $pdo;
    }

    public function createPost($userId, $content) {
        $stmt = $this->pdo->prepare("INSERT INTO posts (user_id, content) VALUES (:user_id, :content)");
        return $stmt->execute(['user_id' => $userId, 'content' => $content]);
    }
}
