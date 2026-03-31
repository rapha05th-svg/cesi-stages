<?php

final class User
{
    public static function findByEmail(string $email): array|false
    {
        $email = trim(mb_strtolower($email));

        $stmt = DB::pdo()->prepare("
            SELECT id, email, password_hash, role, created_at
            FROM users
            WHERE LOWER(email) = :email
            LIMIT 1
        ");
        $stmt->execute([
            'email' => $email,
        ]);

        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public static function find(int $id): array|false
    {
        $stmt = DB::pdo()->prepare("
            SELECT id, email, password_hash, role, created_at
            FROM users
            WHERE id = :id
            LIMIT 1
        ");
        $stmt->execute([
            'id' => $id,
        ]);

        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public static function create(string $email, string $password, string $role): int
    {
        $email = trim(mb_strtolower($email));

        $stmt = DB::pdo()->prepare("
            INSERT INTO users (email, password_hash, role)
            VALUES (:email, :password_hash, :role)
        ");
        $stmt->execute([
            'email' => $email,
            'password_hash' => password_hash($password, PASSWORD_DEFAULT),
            'role' => $role,
        ]);

        return (int) DB::pdo()->lastInsertId();
    }

    public static function updateEmail(int $id, string $email): void
    {
        $email = trim(mb_strtolower($email));

        $stmt = DB::pdo()->prepare("
            UPDATE users
            SET email = :email
            WHERE id = :id
        ");
        $stmt->execute([
            'id' => $id,
            'email' => $email,
        ]);
    }

    public static function updatePassword(int $id, string $newPassword): void
    {
        $stmt = DB::pdo()->prepare("
            UPDATE users
            SET password_hash = :password_hash
            WHERE id = :id
        ");
        $stmt->execute([
            'id' => $id,
            'password_hash' => password_hash($newPassword, PASSWORD_DEFAULT),
        ]);
    }

    public static function delete(int $id): void
    {
        $stmt = DB::pdo()->prepare("
            DELETE FROM users
            WHERE id = :id
        ");
        $stmt->execute([
            'id' => $id,
        ]);
    }
}