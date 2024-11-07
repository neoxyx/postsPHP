<?php

namespace Controllers;

use Services\PostService;

class PostController {
    private $postService;

    public function __construct(PostService $postService) {
        $this->postService = $postService;
    }

    public function createPost($data) {
        if (empty($data['user_id']) || empty($data['content'])) {
            http_response_code(400);
            echo json_encode(["error" => "Datos incompletos"]);
            return;
        }
        $this->postService->createPost($data['user_id'], $data['content']);
        echo json_encode(["message" => "Post creado exitosamente."]);
    }
}
