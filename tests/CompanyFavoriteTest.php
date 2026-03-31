<?php
declare(strict_types=1);

require_once __DIR__ . '/bootstrap.php';
require_once __DIR__ . '/../app/models/CompanyFavorite.php';

final class CompanyFavoriteTest
{
    private PDO $pdo;

    public function __construct()
    {
        $this->pdo = DB::pdo();
    }

    public function run(): void
    {
        echo "<h2>Tests CompanyFavorite</h2>";

        $this->testAddFavorite();
        $this->testRemoveFavorite();

        echo "<p><strong>Tests favoris OK ✅</strong></p>";
    }

    private function testAddFavorite(): void
    {
        $studentId = 1;
        $companyId = 1;

        // clean
        $this->pdo->prepare("
            DELETE FROM company_favorites
            WHERE student_id = ? AND company_id = ?
        ")->execute([$studentId, $companyId]);

        CompanyFavorite::toggle($studentId, $companyId);

        if (!CompanyFavorite::has($studentId, $companyId)) {
            throw new RuntimeException("testAddFavorite échoué");
        }

        echo "<p>testAddFavorite ✅</p>";
    }

    private function testRemoveFavorite(): void
{
    $studentId = 1;
    $companyId = 1;

    // on nettoie d'abord
    $this->pdo->prepare("
        DELETE FROM company_favorites
        WHERE student_id = ? AND company_id = ?
    ")->execute([$studentId, $companyId]);

    // on ajoute explicitement le favori
    $this->pdo->prepare("
        INSERT INTO company_favorites (student_id, company_id)
        VALUES (?, ?)
    ")->execute([$studentId, $companyId]);

    // on vérifie qu'il existe bien avant suppression
    if (!CompanyFavorite::has($studentId, $companyId)) {
        throw new RuntimeException("Précondition testRemoveFavorite échouée");
    }

    // suppression via toggle
    CompanyFavorite::toggle($studentId, $companyId);

    // il ne doit plus exister
    if (CompanyFavorite::has($studentId, $companyId)) {
        throw new RuntimeException("testRemoveFavorite échoué");
    }

    echo "<p>testRemoveFavorite ✅</p>";
}
}

(new CompanyFavoriteTest())->run();