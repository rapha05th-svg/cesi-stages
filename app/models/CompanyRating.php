<?php

final class CompanyRating
{
    public static function getByAuthorAndCompany(int $studentId, int $companyId): ?int
    {
        $stmt = DB::pdo()->prepare("
            SELECT rating
            FROM company_ratings
            WHERE student_id = :student_id
              AND company_id = :company_id
            LIMIT 1
        ");
        $stmt->execute([
            'student_id' => $studentId,
            'company_id' => $companyId,
        ]);

        $value = $stmt->fetchColumn();
        return $value !== false ? (int) $value : null;
    }

    public static function upsert(int $studentId, int $companyId, int $rating): void
    {
        $existing = self::getByAuthorAndCompany($studentId, $companyId);

        if ($existing !== null) {
            $stmt = DB::pdo()->prepare("
                UPDATE company_ratings
                SET rating = :rating
                WHERE student_id = :student_id
                  AND company_id = :company_id
            ");
            $stmt->execute([
                'rating' => $rating,
                'student_id' => $studentId,
                'company_id' => $companyId,
            ]);
            return;
        }

        $stmt = DB::pdo()->prepare("
            INSERT INTO company_ratings (company_id, student_id, rating)
            VALUES (:company_id, :student_id, :rating)
        ");
        $stmt->execute([
            'company_id' => $companyId,
            'student_id' => $studentId,
            'rating' => $rating,
        ]);
    }
}