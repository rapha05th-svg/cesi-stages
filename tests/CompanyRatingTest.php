<?php
declare(strict_types=1);

require_once __DIR__ . '/bootstrap.php';

final class CompanyRatingTest
{
    private PDO $pdo;

    public function __construct()
    {
        $this->pdo = DB::pdo();
    }

    public function run(): void
    {
        echo "<h2>Tests CompanyRating</h2>";

        $this->testCreateRating();
        $this->testUpdateRating();

        echo "<p><strong>Tous les tests sont passés ✅</strong></p>";
    }

    private function testCreateRating(): void
    {
        $studentId = 1;
        $companyId = 1;

        $stmt = $this->pdo->prepare("
            DELETE FROM company_ratings
            WHERE student_id = :student_id
              AND company_id = :company_id
        ");
        $stmt->execute([
            'student_id' => $studentId,
            'company_id' => $companyId,
        ]);

        CompanyRating::upsert($studentId, $companyId, 4);

        $rating = CompanyRating::getByAuthorAndCompany($studentId, $companyId);

        if ($rating !== 4) {
            throw new RuntimeException("testCreateRating échoué : attendu 4, obtenu " . var_export($rating, true));
        }

        echo "<p>testCreateRating ✅</p>";
    }

    private function testUpdateRating(): void
    {
        $studentId = 1;
        $companyId = 1;

        CompanyRating::upsert($studentId, $companyId, 2);
        CompanyRating::upsert($studentId, $companyId, 5);

        $rating = CompanyRating::getByAuthorAndCompany($studentId, $companyId);

        if ($rating !== 5) {
            throw new RuntimeException("testUpdateRating échoué : attendu 5, obtenu " . var_export($rating, true));
        }

        echo "<p>testUpdateRating ✅</p>";
    }
}

$test = new CompanyRatingTest();
$test->run();