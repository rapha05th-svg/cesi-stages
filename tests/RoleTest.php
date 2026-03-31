<?php
declare(strict_types=1);

require_once __DIR__ . '/bootstrap.php';
require_once __DIR__ . '/../app/models/User.php';

final class RoleTest
{
    public function run(): void
    {
        echo "<h2>Tests Rôles</h2>";

        $this->testAdminRole();
        $this->testStudentRole();

        echo "<p><strong>Tests rôles OK ✅</strong></p>";
    }

    private function testAdminRole(): void
    {
        $user = User::findByEmail('admin@cesi.fr');

        if (!$user || $user['role'] !== 'ADMIN') {
            throw new RuntimeException("testAdminRole échoué");
        }

        echo "<p>testAdminRole ✅</p>";
    }

    private function testStudentRole(): void
    {
        $user = User::findByEmail('emma0@cesi.fr');

        if (!$user || $user['role'] !== 'STUDENT') {
            throw new RuntimeException("testStudentRole échoué");
        }

        echo "<p>testStudentRole ✅</p>";
    }
}

(new RoleTest())->run();