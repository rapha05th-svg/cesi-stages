<?php

final class PilotRequest
{
    public static function create(int $pilotId, string $type, string $action, string $message): void
    {
        $stmt = DB::pdo()->prepare("
            INSERT INTO pilot_requests (pilot_id, type, action, message)
            VALUES (:pilot_id, :type, :action, :message)
        ");
        $stmt->execute([
            'pilot_id' => $pilotId,
            'type'     => $type,
            'action'   => $action,
            'message'  => $message,
        ]);
    }

    public static function byPilotId(int $pilotId): array
    {
        $stmt = DB::pdo()->prepare("
            SELECT * FROM pilot_requests
            WHERE pilot_id = :pilot_id
            ORDER BY created_at DESC
        ");
        $stmt->execute(['pilot_id' => $pilotId]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public static function allPending(): array
    {
        $stmt = DB::pdo()->prepare("
            SELECT pr.*, p.firstname, p.lastname
            FROM pilot_requests pr
            JOIN pilots p ON p.id = pr.pilot_id
            WHERE pr.status = 'pending'
            ORDER BY pr.created_at ASC
        ");
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public static function allForAdmin(): array
    {
        $stmt = DB::pdo()->prepare("
            SELECT pr.*, p.firstname, p.lastname
            FROM pilot_requests pr
            JOIN pilots p ON p.id = pr.pilot_id
            ORDER BY
                FIELD(pr.status, 'pending', 'approved', 'rejected'),
                pr.created_at DESC
        ");
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public static function pendingCount(): int
    {
        $stmt = DB::pdo()->query("SELECT COUNT(*) FROM pilot_requests WHERE status = 'pending'");
        return (int) $stmt->fetchColumn();
    }

    public static function find(int $id): array|false
    {
        $stmt = DB::pdo()->prepare("SELECT * FROM pilot_requests WHERE id = :id LIMIT 1");
        $stmt->execute(['id' => $id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public static function approve(int $id, string $adminComment): void
    {
        $stmt = DB::pdo()->prepare("
            UPDATE pilot_requests
            SET status = 'approved', admin_comment = :comment
            WHERE id = :id
        ");
        $stmt->execute(['id' => $id, 'comment' => $adminComment]);
    }

    public static function reject(int $id, string $adminComment): void
    {
        $stmt = DB::pdo()->prepare("
            UPDATE pilot_requests
            SET status = 'rejected', admin_comment = :comment
            WHERE id = :id
        ");
        $stmt->execute(['id' => $id, 'comment' => $adminComment]);
    }
}
