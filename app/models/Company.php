<?php

final class Company
{
    public static function count(string $q = ''): int
    {
        $pdo = DB::pdo();

        if ($q !== '') {
            $stmt = $pdo->prepare("
                SELECT COUNT(*)
                FROM companies c
                WHERE c.is_active = 1
                  AND (c.name LIKE :q OR c.description LIKE :q)
            ");
            $stmt->execute(['q' => '%' . $q . '%']);
            return (int) $stmt->fetchColumn();
        }

        return (int) $pdo->query("
            SELECT COUNT(*)
            FROM companies c
            WHERE c.is_active = 1
        ")->fetchColumn();
    }

    public static function countAdmin(): int
    {
        return (int) DB::pdo()->query("
            SELECT COUNT(*)
            FROM companies
        ")->fetchColumn();
    }

    public static function search(string $q = '', int $limit = 10, int $offset = 0): array
    {
        $pdo = DB::pdo();

        $sql = "
            SELECT
                c.id,
                c.name,
                c.description,
                c.email AS email_contact,
                c.phone AS phone_contact,
                COALESCE(AVG(cr.rating), 0) AS avg_rating,
                COUNT(DISTINCT a.id) AS applications_count
            FROM companies c
            LEFT JOIN offers o ON o.company_id = c.id
            LEFT JOIN applications a ON a.offer_id = o.id
            LEFT JOIN company_ratings cr ON cr.company_id = c.id
            WHERE c.is_active = 1
        ";

        if ($q !== '') {
            $sql .= " AND (c.name LIKE :q OR c.description LIKE :q)";
        }

        $sql .= "
            GROUP BY c.id, c.name, c.description, c.email, c.phone
            ORDER BY c.name ASC
            LIMIT :limit OFFSET :offset
        ";

        $stmt = $pdo->prepare($sql);

        if ($q !== '') {
            $stmt->bindValue(':q', '%' . $q . '%', PDO::PARAM_STR);
        }

        $stmt->bindValue(':limit', $limit, PDO::PARAM_INT);
        $stmt->bindValue(':offset', $offset, PDO::PARAM_INT);

        $stmt->execute();
        return $stmt->fetchAll();
    }

    public static function searchAdmin(string $q = ''): array
    {
        $pdo = DB::pdo();

        $sql = "
            SELECT
                id,
                name,
                description,
                email,
                phone,
                is_active
            FROM companies
            WHERE 1=1
        ";

        $params = [];

        if ($q !== '') {
            $sql .= " AND (name LIKE :q OR description LIKE :q)";
            $params['q'] = '%' . $q . '%';
        }

        $sql .= " ORDER BY id DESC";

        $stmt = $pdo->prepare($sql);
        $stmt->execute($params);

        return $stmt->fetchAll();
    }

    public static function find(int $id): array|false
    {
        $stmt = DB::pdo()->prepare("
            SELECT
                c.id,
                c.name,
                c.description,
                c.email AS email_contact,
                c.phone AS phone_contact,
                COALESCE(AVG(cr.rating), 0) AS avg_rating,
                COUNT(DISTINCT a.id) AS applications_count
            FROM companies c
            LEFT JOIN offers o ON o.company_id = c.id
            LEFT JOIN applications a ON a.offer_id = o.id
            LEFT JOIN company_ratings cr ON cr.company_id = c.id
            WHERE c.id = :id AND c.is_active = 1
            GROUP BY c.id, c.name, c.description, c.email, c.phone
        ");

        $stmt->execute(['id' => $id]);
        $company = $stmt->fetch();

        if (!$company) {
            return false;
        }

        $offersStmt = DB::pdo()->prepare("
            SELECT id, title, NULL AS offer_date
            FROM offers
            WHERE company_id = :company_id
            ORDER BY id DESC
        ");
        $offersStmt->execute(['company_id' => $id]);
        $company['offers'] = $offersStmt->fetchAll();

        return $company;
    }

    public static function findAdmin(int $id): array|false
    {
        $stmt = DB::pdo()->prepare("
            SELECT
                id,
                name,
                description,
                email,
                phone,
                is_active
            FROM companies
            WHERE id = :id
            LIMIT 1
        ");
        $stmt->execute(['id' => $id]);

        return $stmt->fetch();
    }

    public static function createAdmin(string $name, string $description, string $email, string $phone): void
    {
        $stmt = DB::pdo()->prepare("
            INSERT INTO companies (name, description, email, phone, is_active)
            VALUES (:name, :description, :email, :phone, 1)
        ");

        $stmt->execute([
            'name' => $name,
            'description' => $description,
            'email' => $email !== '' ? $email : null,
            'phone' => $phone !== '' ? $phone : null,
        ]);
    }

    public static function updateAdmin(int $id, string $name, string $description, string $email, string $phone): void
    {
        $stmt = DB::pdo()->prepare("
            UPDATE companies
            SET
                name = :name,
                description = :description,
                email = :email,
                phone = :phone
            WHERE id = :id
        ");

        $stmt->execute([
            'id' => $id,
            'name' => $name,
            'description' => $description,
            'email' => $email !== '' ? $email : null,
            'phone' => $phone !== '' ? $phone : null,
        ]);
    }

    public static function deleteAdmin(int $id): void
    {
        $stmt = DB::pdo()->prepare("
            UPDATE companies
            SET is_active = 0
            WHERE id = :id
        ");

        $stmt->execute([
            'id' => $id,
        ]);
    }
}