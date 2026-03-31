<?php

final class Application
{
    public static function create(int $studentId, int $offerId, ?string $cvPath, string $letter): void
    {
        $stmt = DB::pdo()->prepare("
            INSERT INTO applications (student_id, offer_id, cover_letter_text, cv_path)
            VALUES (:student_id, :offer_id, :cover_letter_text, :cv_path)
        ");

        $stmt->execute([
            'student_id' => $studentId,
            'offer_id' => $offerId,
            'cover_letter_text' => $letter,
            'cv_path' => $cvPath,
        ]);
    }

    public static function alreadyApplied(int $studentId, int $offerId): bool
    {
        $stmt = DB::pdo()->prepare("
            SELECT 1
            FROM applications
            WHERE student_id = :student_id AND offer_id = :offer_id
            LIMIT 1
        ");
        $stmt->execute([
            'student_id' => $studentId,
            'offer_id' => $offerId,
        ]);

        return (bool) $stmt->fetchColumn();
    }

    public static function forStudent(int $studentId): array
    {
        $stmt = DB::pdo()->prepare("
            SELECT
                a.id,
                a.created_at,
                a.cover_letter_text,
                a.cv_path,
                o.id AS offer_id,
                o.title,
                c.name AS company_name
            FROM applications a
            JOIN offers o ON o.id = a.offer_id
            JOIN companies c ON c.id = o.company_id
            WHERE a.student_id = :student_id
            ORDER BY a.created_at DESC
        ");

        $stmt->execute([
            'student_id' => $studentId,
        ]);

        return $stmt->fetchAll();
    }

    public static function byPilot(int $pilotId): array
    {
        $stmt = DB::pdo()->prepare("
            SELECT
                a.id,
                a.created_at,
                a.cover_letter_text,
                a.cv_path,
                o.id AS offer_id,
                o.title,
                c.name AS company_name,
                s.firstname,
                s.lastname
            FROM applications a
            JOIN offers o ON o.id = a.offer_id
            JOIN companies c ON c.id = o.company_id
            JOIN students s ON s.id = a.student_id
            WHERE s.pilot_id = :pilot_id
            ORDER BY a.created_at DESC
        ");

        $stmt->execute([
            'pilot_id' => $pilotId,
        ]);

        return $stmt->fetchAll();
    }
}