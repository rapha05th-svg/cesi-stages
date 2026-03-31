<?php

final class PasswordReset
{
    public static function create(int $userId): string
    {
        // Supprimer tous les tokens existants pour cet utilisateur
        self::deleteByUserId($userId);

        $token         = bin2hex(random_bytes(32));
        $expiryMinutes = App::config()['token']['expiry_minutes'] ?? 60;
        $expiresAt     = date('Y-m-d H:i:s', time() + ($expiryMinutes * 60));

        $stmt = DB::pdo()->prepare("
            INSERT INTO password_resets (user_id, token, expires_at)
            VALUES (:user_id, :token, :expires_at)
        ");
        $stmt->execute([
            'user_id'    => $userId,
            'token'      => $token,
            'expires_at' => $expiresAt,
        ]);

        return $token;
    }

    public static function findValid(string $token): array|false
    {
        $stmt = DB::pdo()->prepare("
            SELECT id, user_id, token, expires_at
            FROM password_resets
            WHERE token = :token
              AND expires_at > NOW()
              AND used_at IS NULL
            LIMIT 1
        ");
        $stmt->execute(['token' => $token]);

        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public static function markUsed(int $id): void
    {
        $stmt = DB::pdo()->prepare("
            UPDATE password_resets
            SET used_at = NOW()
            WHERE id = :id
        ");
        $stmt->execute(['id' => $id]);
    }

    public static function deleteByUserId(int $userId): void
    {
        $stmt = DB::pdo()->prepare("
            DELETE FROM password_resets
            WHERE user_id = :user_id
        ");
        $stmt->execute(['user_id' => $userId]);
    }

    public static function deleteExpired(): void
    {
        DB::pdo()->exec("DELETE FROM password_resets WHERE expires_at <= NOW()");
    }
}
