<?php

use PHPUnit\Framework\TestCase;
use Services\PostService;
use Repositories\PostRepository;

class PostTest extends TestCase {
    private $postService;
    private $postRepositoryMock;

    protected function setUp(): void {
        // Crear un mock de PostRepository
        $this->postRepositoryMock = $this->createMock(PostRepository::class);
        
        // Inyectar el mock en PostService
        $this->postService = new PostService($this->postRepositoryMock);
    }

    /**
     * Prueba para la creación de un post exitoso
     */
    public function testCreatePostSuccess() {
        $postData = [
            'title' => 'Test Title',
            'content' => 'This is a test content.',
            'user_id' => 1
        ];

        // Configurar el mock para devolver true al llamar al método create
        $this->postRepositoryMock->expects($this->once())
            ->method('create')
            ->with($postData)
            ->willReturn(true);

        // Llamar a createPost y verificar que el resultado sea true
        $result = $this->postService->createPost($postData);
        $this->assertTrue($result, 'The post should be created successfully.');
    }

    /**
     * Prueba para creación de un post con datos incompletos
     */
    public function testCreatePostMissingData() {
        $this->expectException(InvalidArgumentException::class);

        $postData = [
            'title' => 'Test Title',
            // Falta el campo 'content'
            'user_id' => 1
        ];

        // Esto debería lanzar una excepción debido a datos incompletos
        $this->postService->createPost($postData);
    }

    /**
     * Prueba para obtener posts por categoría con éxito
     */
    public function testGetPostsByCategorySuccess() {
        $categoryId = 1;
        $expectedPosts = [
            ['id' => 1, 'title' => 'Post 1', 'content' => 'Content 1', 'user_id' => 1],
            ['id' => 2, 'title' => 'Post 2', 'content' => 'Content 2', 'user_id' => 2],
        ];

        // Configurar el mock para devolver los posts esperados al llamar a findByCategory
        $this->postRepositoryMock->expects($this->once())
            ->method('findByCategory')
            ->with($categoryId)
            ->willReturn($expectedPosts);

        // Llamar a getPostsByCategory y verificar que los posts sean los esperados
        $result = $this->postService->getPostsByCategory($categoryId);
        $this->assertEquals($expectedPosts, $result, 'The posts returned should match the expected posts.');
    }

    /**
     * Prueba para obtener posts por categoría con un ID inválido
     */
    public function testGetPostsByInvalidCategory() {
        $this->expectException(InvalidArgumentException::class);

        $categoryId = -1;  // ID de categoría inválido

        // Esto debería lanzar una excepción debido a un ID de categoría inválido
        $this->postService->getPostsByCategory($categoryId);
    }
}
