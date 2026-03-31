<?php

final class AdminStats
{
    public static function totalCompanies(): int
    {
        return (int) DB::pdo()->query("SELECT COUNT(*) FROM companies")->fetchColumn();
    }

    public static function totalOffers(): int
    {
        return (int) DB::pdo()->query("SELECT COUNT(*) FROM offers")->fetchColumn();
    }

    public static function totalStudents(): int
    {
        return (int) DB::pdo()->query("SELECT COUNT(*) FROM students")->fetchColumn();
    }

    public static function totalPilots(): int
    {
        return (int) DB::pdo()->query("SELECT COUNT(*) FROM pilots")->fetchColumn();
    }

    public static function totalApplications(): int
    {
        return (int) DB::pdo()->query("SELECT COUNT(*) FROM applications")->fetchColumn();
    }

    public static function totalWishlists(): int
    {
        return (int) DB::pdo()->query("SELECT COUNT(*) FROM wishlists")->fetchColumn();
    }

    public static function avgSalary(): float
    {
        return (float) DB::pdo()->query(
            "SELECT COALESCE(AVG(salary), 0) FROM offers WHERE salary IS NOT NULL AND is_active = 1"
        )->fetchColumn();
    }

    public static function recentApplications(int $limit = 5): array
    {
        $stmt = DB::pdo()->prepare("
            SELECT a.id, o.title AS offer_title, s.firstname, s.lastname, a.created_at
            FROM applications a
            JOIN offers o ON o.id = a.offer_id
            JOIN students s ON s.id = a.student_id
            ORDER BY a.created_at DESC
            LIMIT :limit
        ");
        $stmt->bindValue(':limit', $limit, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll();
    }

    public static function offersByMonth(): array
    {
        return DB::pdo()->query("
            SELECT DATE_FORMAT(created_at, '%m/%Y') AS month, COUNT(*) AS total
            FROM offers
            WHERE created_at >= DATE_SUB(NOW(), INTERVAL 6 MONTH)
            GROUP BY month
            ORDER BY created_at ASC
        ")->fetchAll();
    }

    public static function topCompaniesByApplications(int $limit = 5): array
    {
        $stmt = DB::pdo()->prepare("
            SELECT c.id, c.name, COUNT(a.id) AS applications_count
            FROM companies c
            LEFT JOIN offers o ON o.company_id = c.id
            LEFT JOIN applications a ON a.offer_id = o.id
            GROUP BY c.id, c.name
            ORDER BY applications_count DESC, c.name ASC
            LIMIT :limit
        ");
        $stmt->bindValue(':limit', $limit, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll();
    }
}