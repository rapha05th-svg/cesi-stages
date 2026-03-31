<?php
declare(strict_types=1);

require_once __DIR__ . '/bootstrap.php';
require_once __DIR__ . '/../app/models/Application.php';

final class ApplicationTest
{
    private PDO $pdo;

    public function __construct()
    {
        $this->pdo = DB::pdo();
    }

    public function run(): void
    {
        echo "<h2>Tests Applications</h2>";

        $this->testCreateApplication();
        $this->testPreventDuplicate();

        echo "<p><strong>Tests candidatures OK ✅</strong></p>";
    }

    private function testCreateApplication(): void
    {
        $studentId = 1;
        $offerId = 1;
        $coverLetter = 'Lettre de motivation de test';
        $cvPath = 'uploads/test_cv.pdf';

        $this->pdo->prepare("
            DELETE FROM applications
            WHERE student_id = ? AND offer_id = ?
        ")->execute([$studentId, $offerId]);

        Application::create($studentId, $offerId, $coverLetter, $cvPath);

        $stmt = $this->pdo->prepare("
            SELECT COUNT(*)
            FROM applications
            WHERE student_id = ? AND offer_id = ?
        ");
        $stmt->execute([$studentId, $offerId]);

        if ((int) $stmt->fetchColumn() !== 1) {
            throw new RuntimeException("testCreateApplication échoué");
        }

        echo "<p>testCreateApplication ✅</p>";
    }

    private function testPreventDuplicate(): void
    {
        $studentId = 1;
        $offerId = 1;
        $coverLetter = 'Lettre de motivation de test';
        $cvPath = 'uploads/test_cv.pdf';

        $this->pdo->prepare("
            DELETE FROM applications
            WHERE student_id = ? AND offer_id = ?
        ")->execute([$studentId, $offerId]);

        Application::create($studentId, $offerId, $coverLetter, $cvPath);

        try {
            Application::create($studentId, $offerId, $coverLetter, $cvPath);
        } catch (Throwable $e) {
            // si la contrainte d'unicité empêche le doublon, c'est acceptable
        }

        $stmt = $this->pdo->prepare("
            SELECT COUNT(*)
            FROM applications
            WHERE student_id = ? AND offer_id = ?
        ");
        $stmt->execute([$studentId, $offerId]);

        if ((int) $stmt->fetchColumn() > 1) {
            throw new RuntimeException("testPreventDuplicate échoué");
        }

        echo "<p>testPreventDuplicate ✅</p>";
    }
}

(new ApplicationTest())->run();