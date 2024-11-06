<?php
namespace Repositories;

use PDO;

class PostRepository {
    private $db;

    public function __construct(PDO $db) {
        $this->db = $db;
    }

    public function create(array $data): bool {
        $query = "INSERT INTO posts (title, content, user_id) VALUES (:title, :content, :user_id)";
        $stmt = $this->db->prepare($query);
        
        return $stmt->execute([
            'title' => $data['title'],
            'content' => $data['content'],
            'user_id' => $data['user_id']
        ]);
    }

    public function findByCategory(int $categoryId): array {
        $query = "SELECT * FROM posts WHERE category_id = :category_id";
        $stmt = $this->db->prepare($query);
        $stmt->execute(['category_id' => $categoryId]);
        
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}
?>
