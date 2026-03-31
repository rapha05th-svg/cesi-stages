<?php

final class App
{
    private static array $config = [];

    public static function init(array $config): void
    {
        self::$config = $config;

        DB::init(
            $config['db']['dsn'],
            $config['db']['user'],
            $config['db']['pass']
        );
    }

    public static function config(): array
    {
        return self::$config;
    }
}