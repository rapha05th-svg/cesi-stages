<?php

return [
    'app' => [
        'base_path' => '',
    ],
    'db' => [
        'dsn'  => 'mysql:host=127.0.0.1;port=3306;dbname=cesi_stages;charset=utf8mb4',
        'user' => 'root',
        'pass' => '',
    ],
    'mail' => [
        'from_email' => 'noreply@cesi-stages.local',
        'from_name'  => 'CESI Stages',
        // true  = mode développement : le lien s'affiche sur la page (aucun mail envoyé)
        // false = mode production : envoi via la fonction mail() de PHP
        'debug'      => true,
    ],
    'token' => [
        // Durée de validité du token de réinitialisation (en minutes)
        'expiry_minutes' => 60,
    ],
];