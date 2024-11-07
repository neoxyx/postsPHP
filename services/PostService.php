<?php

namespace Services;

use Repositories\PostRepository;

class PostService {
    private $postRepository;

    public function __construct(PostRepository $postRepository) {
        $this->postRepository = $postRepository;
    }

    public function createPost($userId, $content) {
        return $this->postRepository->createPost($userId, $content);
    }
}
