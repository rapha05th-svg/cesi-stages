<?php

final class DB
{
    private static ?PDO $pdo = null;

    public static function init(string $dsn, string $user, string $pass): void
    {
        if (self::$pdo !== null) {
            return;
        }

        self::$pdo = new PDO($dsn, $user, $pass, [
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
        ]);
    }

    public static function pdo(): PDO
    {
        if (self::$pdo === null) {
            throw new RuntimeException('Connexion à la base non initialisée.');
        }

        return self::$pdo;
    }
}