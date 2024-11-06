<?php
use PHPUnit\Framework\TestCase;
use Services\AuthService;
use Repositories\UserRepository;

class AuthServiceTest extends TestCase {
    public function testRegister() {
        $mockRepo = $this->createMock(UserRepository::class);
        $mockRepo->method('save')->willReturn(true);

        $authService = new AuthService($mockRepo);
        $result = $authService->register([
            'name' => 'John Doe',
            'email' => 'john@example.com',
            'password' => 'password123'
        ]);

        $this->assertTrue($result);
    }

    public function testLogin() {
        $mockRepo = $this->createMock(UserRepository::class);
        $mockRepo->method('findByEmail')->willReturn([
            'email' => 'john@example.com',
            'password' => password_hash('password123', PASSWORD_BCRYPT)
        ]);

        $authService = new AuthService($mockRepo);
        $token = $authService->login('john@example.com', 'password123');

        $this->assertNotNull($token);
    }
}
?>
