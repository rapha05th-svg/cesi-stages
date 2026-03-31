<?php

final class CompanyFavorite
{
    public static function has(int $studentId, int $companyId): bool
    {
        $stmt = DB::pdo()->prepare("
            SELECT 1
            FROM company_favorites
            WHERE student_id = :student_id
              AND company_id = :company_id
            LIMIT 1
        ");
        $stmt->execute([
            'student_id' => $studentId,
            'company_id' => $companyId,
        ]);

        return (bool) $stmt->fetchColumn();
    }

    public static function toggle(int $studentId, int $companyId): void
    {
        if (self::has($studentId, $companyId)) {
            $stmt = DB::pdo()->prepare("
                DELETE FROM company_favorites
                WHERE student_id = :student_id
                  AND company_id = :company_id
            ");
            $stmt->execute([
                'student_id' => $studentId,
                'company_id' => $companyId,
            ]);
            return;
        }

        $stmt = DB::pdo()->prepare("
            INSERT INTO company_favorites (student_id, company_id)
            VALUES (:student_id, :company_id)
        ");
        $stmt->execute([
            'student_id' => $studentId,
            'company_id' => $companyId,
        ]);
    }

    public static function forStudent(int $studentId): array
    {
        $stmt = DB::pdo()->prepare("
            SELECT
                c.id,
                c.name,
                c.description,
                c.email,
                c.phone,
                c.is_active,
                cf.created_at
            FROM company_favorites cf
            INNER JOIN companies c ON c.id = cf.company_id
            WHERE cf.student_id = :student_id
            ORDER BY cf.created_at DESC, c.name ASC
        ");
        $stmt->execute([
            'student_id' => $studentId,
        ]);

        return $stmt->fetchAll();
    }
}