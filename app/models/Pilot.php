<?php

final class Pilot
{
    public static function idByUserId(int $userId): ?int
    {
        $stmt = DB::pdo()->prepare("
            SELECT id
            FROM pilots
            WHERE user_id = :user_id
            LIMIT 1
        ");
        $stmt->execute([
            'user_id' => $userId,
        ]);

        $value = $stmt->fetchColumn();
        return $value !== false ? (int) $value : null;
    }

    public static function allAdmin(string $q = ''): array
    {
        $sql = "
            SELECT
                p.id,
                p.user_id,
                p.firstname,
                p.lastname,
                u.email
            FROM pilots p
            INNER JOIN users u ON u.id = p.user_id
            WHERE 1=1
        ";

        $params = [];

        if ($q !== '') {
            $sql .= " AND (
                p.firstname LIKE :q
                OR p.lastname LIKE :q
                OR u.email LIKE :q
            )";
            $params['q'] = '%' . $q . '%';
        }

        $sql .= " ORDER BY p.id DESC";

        $stmt = DB::pdo()->prepare($sql);
        $stmt->execute($params);

        return $stmt->fetchAll();
    }

    public static function findAdmin(int $id): array|false
    {
        $stmt = DB::pdo()->prepare("
            SELECT
                p.*,
                u.email
            FROM pilots p
            INNER JOIN users u ON u.id = p.user_id
            WHERE p.id = :id
            LIMIT 1
        ");
        $stmt->execute([
            'id' => $id,
        ]);

        return $stmt->fetch();
    }

    public static function createAdmin(int $userId, string $firstname, string $lastname): int
    {
        $stmt = DB::pdo()->prepare("
            INSERT INTO pilots (user_id, firstname, lastname)
            VALUES (:user_id, :firstname, :lastname)
        ");
        $stmt->execute([
            'user_id' => $userId,
            'firstname' => $firstname,
            'lastname' => $lastname,
        ]);

        return (int) DB::pdo()->lastInsertId();
    }

    public static function updateAdmin(int $id, string $firstname, string $lastname): void
    {
        $stmt = DB::pdo()->prepare("
            UPDATE pilots
            SET
                firstname = :firstname,
                lastname = :lastname
            WHERE id = :id
        ");
        $stmt->execute([
            'id' => $id,
            'firstname' => $firstname,
            'lastname' => $lastname,
        ]);
    }

    public static function deleteAdmin(int $id): void
    {
        DB::pdo()->prepare("
            UPDATE students
            SET pilot_id = NULL
            WHERE pilot_id = :pilot_id
        ")->execute([
            'pilot_id' => $id,
        ]);

        DB::pdo()->prepare("
            DELETE FROM pilots
            WHERE id = :id
        ")->execute([
            'id' => $id,
        ]);
    }
}