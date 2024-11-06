<?php
namespace Services;

use Repositories\PostRepository;

class PostService {
    private $postRepository;

    public function __construct(PostRepository $postRepository) {
        $this->postRepository = $postRepository;
    }

    /**
     * Crear un nuevo post
     * @param array $data
     * @return bool
     */
    public function createPost(array $data): bool {
        // Validación básica de datos
        if (empty($data['title']) || empty($data['content']) || empty($data['user_id'])) {
            throw new \InvalidArgumentException("Todos los campos son obligatorios.");
        }

        // Delegar al repositorio para guardar el post
        return $this->postRepository->create($data);
    }

    /**
     * Obtener todos los posts de una categoría
     * @param int $categoryId
     * @return array
     */
    public function getPostsByCategory(int $categoryId): array {
        if ($categoryId <= 0) {
            throw new \InvalidArgumentException("ID de categoría inválido.");
        }

        // Delegar al repositorio para obtener los posts de la categoría
        return $this->postRepository->findByCategory($categoryId);
    }
}
?>
