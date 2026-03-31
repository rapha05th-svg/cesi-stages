public static function findByEmail(string $email): ?array
{
    $stmt = DB::pdo()->prepare("
        SELECT *
        FROM users
        WHERE email = :email
        LIMIT 1
    ");

    $stmt->execute(['email' => $email]);
    return $stmt->fetch() ?: null;
}