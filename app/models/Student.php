<?php

final class Student
{
    public static function idByUserId(int $userId): ?int
    {
        $stmt = DB::pdo()->prepare("
            SELECT id
            FROM students
            WHERE user_id = :user_id
            LIMIT 1
        ");
        $stmt->execute([
            'user_id' => $userId,
        ]);

        $value = $stmt->fetchColumn();
        return $value !== false ? (int) $value : null;
    }

    public static function findByUserId(int $userId): array|false
    {
        $stmt = DB::pdo()->prepare("
            SELECT *
            FROM students
            WHERE user_id = :user_id
            LIMIT 1
        ");
        $stmt->execute([
            'user_id' => $userId,
        ]);

        return $stmt->fetch();
    }

    public static function allAdmin(string $q = ''): array
    {
        $sql = "
            SELECT
                s.id,
                s.user_id,
                s.firstname,
                s.lastname,
                s.pilot_id,
                u.email,
                p.firstname AS pilot_firstname,
                p.lastname AS pilot_lastname
            FROM students s
            INNER JOIN users u ON u.id = s.user_id
            LEFT JOIN pilots p ON p.id = s.pilot_id
            WHERE 1=1
        ";

        $params = [];

        if ($q !== '') {
            $sql .= " AND (
                s.firstname LIKE :q
                OR s.lastname LIKE :q
                OR u.email LIKE :q
            )";
            $params['q'] = '%' . $q . '%';
        }

        $sql .= " ORDER BY s.id DESC";

        $stmt = DB::pdo()->prepare($sql);
        $stmt->execute($params);

        return $stmt->fetchAll();
    }

    public static function findAdmin(int $id): array|false
    {
        $stmt = DB::pdo()->prepare("
            SELECT
                s.*,
                u.email
            FROM students s
            INNER JOIN users u ON u.id = s.user_id
            WHERE s.id = :id
            LIMIT 1
        ");
        $stmt->execute([
            'id' => $id,
        ]);

        return $stmt->fetch();
    }

    public static function createAdmin(int $userId, string $firstname, string $lastname, ?int $pilotId): int
    {
        $stmt = DB::pdo()->prepare("
            INSERT INTO students (user_id, firstname, lastname, pilot_id)
            VALUES (:user_id, :firstname, :lastname, :pilot_id)
        ");
        $stmt->execute([
            'user_id' => $userId,
            'firstname' => $firstname,
            'lastname' => $lastname,
            'pilot_id' => $pilotId ?: null,
        ]);

        return (int) DB::pdo()->lastInsertId();
    }

    public static function updateAdmin(int $id, string $firstname, string $lastname, ?int $pilotId): void
    {
        $stmt = DB::pdo()->prepare("
            UPDATE students
            SET
                firstname = :firstname,
                lastname = :lastname,
                pilot_id = :pilot_id
            WHERE id = :id
        ");
        $stmt->execute([
            'id' => $id,
            'firstname' => $firstname,
            'lastname' => $lastname,
            'pilot_id' => $pilotId ?: null,
        ]);
    }

    public static function deleteAdmin(int $id): void
    {
        $stmt = DB::pdo()->prepare("
            DELETE FROM students
            WHERE id = :id
        ");
        $stmt->execute([
            'id' => $id,
        ]);
    }
}