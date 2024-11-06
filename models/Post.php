<?php
namespace Models;

class Post {
    private $db;

    public function __construct($db) {
        $this->db = $db;
    }

    public function create($title, $content, $userId, $categoryId) {
        $stmt = $this->db->prepare("INSERT INTO posts (title, content, user_id, category_id) VALUES (:title, :content, :user_id, :category_id)");
        $stmt->execute([
            ':title' => $title,
            ':content' => $content,
            ':user_id' => $userId,
            ':category_id' => $categoryId
        ]);
    }

    public function getByCategory($categoryId) {
        $stmt = $this->db->prepare("SELECT * FROM posts WHERE category_id = :category_id");
        $stmt->execute([':category_id' => $categoryId]);
        return $stmt->fetchAll();
    }
}
?>
