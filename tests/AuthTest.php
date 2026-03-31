<?php
declare(strict_types=1);

require_once __DIR__ . '/bootstrap.php';
require_once __DIR__ . '/../app/models/User.php';

final class AuthTest
{
    private PDO $pdo;

    public function __construct()
    {
        $this->pdo = DB::pdo();
    }

    public function run(): void
    {
        echo "<h2>Tests Auth</h2>";

        $this->testLoginSuccess();
        $this->testLoginFail();

        echo "<p><strong>Tests auth OK ✅</strong></p>";
    }

    private function testLoginSuccess(): void
    {
        $email = 'admin@cesi.fr';
        $password = 'admin123';

        $user = User::findByEmail($email);

        if (!$user || !password_verify($password, $user['password_hash'])) {
            throw new RuntimeException("testLoginSuccess échoué");
        }

        echo "<p>testLoginSuccess ✅</p>";
    }

    private function testLoginFail(): void
    {
        $email = 'admin@cesi.fr';
        $password = 'wrongpassword';

        $user = User::findByEmail($email);

        if ($user && password_verify($password, $user['password_hash'])) {
            throw new RuntimeException("testLoginFail échoué");
        }

        echo "<p>testLoginFail ✅</p>";
    }
}

(new AuthTest())->run();