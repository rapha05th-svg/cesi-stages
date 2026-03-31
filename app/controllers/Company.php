<?php

final class Company
{
    public static function count(string $q = ''): int
    {
        $pdo = DB::pdo();

        if ($q !== '') {
            $stmt = $pdo->prepare("
                SELECT COUNT(*)
                FROM companies
                WHERE is_active = 1
                  AND (name LIKE :q OR description LIKE :q)
            ");
            $stmt->execute(['q' => '%' . $q . '%']);
            return (int) $stmt->fetchColumn();
        }

        return (int) $pdo->query("
            SELECT COUNT(*)
            FROM companies
            WHERE is_active = 1
        ")->fetchColumn();
    }

    public static function search(string $q = '', int $limit = 8, int $offset = 0): array
    {
        $pdo = DB::pdo();

        if ($q !== '') {
            $stmt = $pdo->prepare("
                SELECT id, name, description, email_contact, phone_contact
                FROM companies
                WHERE is_active = 1
                  AND (name LIKE :q OR description LIKE :q)
                ORDER BY name ASC
                LIMIT :limit OFFSET :offset
            ");
            $stmt->bindValue(':q', '%' . $q . '%', PDO::PARAM_STR);
            $stmt->bindValue(':limit', $limit, PDO::PARAM_INT);
            $stmt->bindValue(':offset', $offset, PDO::PARAM_INT);
            $stmt->execute();
            return $stmt->fetchAll();
        }

        $stmt = $pdo->prepare("
            SELECT id, name, description, email_contact, phone_contact
            FROM companies
            WHERE is_active = 1
            ORDER BY name ASC
            LIMIT :limit OFFSET :offset
        ");
        $stmt->bindValue(':limit', $limit, PDO::PARAM_INT);
        $stmt->bindValue(':offset', $offset, PDO::PARAM_INT);
        $stmt->execute();

        return $stmt->fetchAll();
    }

    public static function find(int $id): array|false
    {
        $stmt = DB::pdo()->prepare("
            SELECT id, name, description, email_contact, phone_contact
            FROM companies
            WHERE id = :id AND is_active = 1
        ");
        $stmt->execute(['id' => $id]);

        return $stmt->fetch();
    }
}