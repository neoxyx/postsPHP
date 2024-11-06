<?php
namespace Controllers;

use Services\PostService;

class PostController {
    private $postService;

    public function __construct(PostService $postService) {
        $this->postService = $postService;
    }

    public function createPost($data) {
        return $this->postService->create($data);
    }

    public function getPostsByCategory($categoryId) {
        return $this->postService->getByCategory($categoryId);
    }
}
?>
