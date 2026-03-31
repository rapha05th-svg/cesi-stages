<?php

final class Wishlist
{
    public static function getOffersByUser(int $studentId): array
    {
        $stmt = DB::pdo()->prepare("
            SELECT 
                o.id,
                o.title,
                o.description,
                o.company_id,
                c.name AS company_name
            FROM wishlists w
            JOIN offers o ON o.id = w.offer_id
            JOIN companies c ON c.id = o.company_id
            WHERE w.student_id = :student_id
            ORDER BY o.id DESC
        ");
        $stmt->execute([
            'student_id' => $studentId,
        ]);

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public static function has(int $studentId, int $offerId): bool
    {
        $stmt = DB::pdo()->prepare("
            SELECT 1
            FROM wishlists
            WHERE student_id = :student_id AND offer_id = :offer_id
            LIMIT 1
        ");
        $stmt->execute([
            'student_id' => $studentId,
            'offer_id' => $offerId,
        ]);

        return (bool) $stmt->fetchColumn();
    }

    public static function addOffer(int $studentId, int $offerId): void
    {
        if (self::has($studentId, $offerId)) {
            return;
        }

        $stmt = DB::pdo()->prepare("
            INSERT INTO wishlists (student_id, offer_id)
            VALUES (:student_id, :offer_id)
        ");
        $stmt->execute([
            'student_id' => $studentId,
            'offer_id' => $offerId,
        ]);
    }

    public static function removeOffer(int $studentId, int $offerId): void
    {
        $stmt = DB::pdo()->prepare("
            DELETE FROM wishlists
            WHERE student_id = :student_id AND offer_id = :offer_id
        ");
        $stmt->execute([
            'student_id' => $studentId,
            'offer_id' => $offerId,
        ]);
    }

    public static function toggleOffer(int $studentId, int $offerId): void
    {
        if (self::has($studentId, $offerId)) {
            self::removeOffer($studentId, $offerId);
            return;
        }

        self::addOffer($studentId, $offerId);
    }
}