<?php

declare(strict_types=1);

session_start();

// En-têtes de sécurité HTTP (STx11)
header('X-Frame-Options: DENY');
header('X-Content-Type-Options: nosniff');
header('X-XSS-Protection: 1; mode=block');
header('Referrer-Policy: strict-origin-when-cross-origin');
header("Content-Security-Policy: default-src 'self' http://static.cesi-stages.local; script-src 'self' 'unsafe-inline'; style-src 'self' 'unsafe-inline' http://static.cesi-stages.local; img-src 'self' http://static.cesi-stages.local data:;");

require_once __DIR__ . '/../app/core/App.php';
require_once __DIR__ . '/../app/core/Auth.php';
require_once __DIR__ . '/../app/core/Controller.php';
require_once __DIR__ . '/../app/core/Csrf.php';
require_once __DIR__ . '/../app/core/DB.php';
require_once __DIR__ . '/../app/core/Paginator.php';
require_once __DIR__ . '/../app/core/Router.php';
require_once __DIR__ . '/../app/core/Validator.php';
require_once __DIR__ . '/../app/core/View.php';

require_once __DIR__ . '/../app/controllers/HomeController.php';
require_once __DIR__ . '/../app/controllers/AuthController.php';
require_once __DIR__ . '/../app/controllers/CompanyController.php';
require_once __DIR__ . '/../app/controllers/OfferController.php';
require_once __DIR__ . '/../app/controllers/StatsController.php';
require_once __DIR__ . '/../app/controllers/WishlistController.php';
require_once __DIR__ . '/../app/controllers/ApplicationController.php';
require_once __DIR__ . '/../app/controllers/PilotController.php';
require_once __DIR__ . '/../app/controllers/AdminController.php';
require_once __DIR__ . '/../app/controllers/CompanyFavoriteController.php';

require_once __DIR__ . '/../app/models/Company.php';
require_once __DIR__ . '/../app/models/Offer.php';
require_once __DIR__ . '/../app/models/User.php';
require_once __DIR__ . '/../app/models/Application.php';
require_once __DIR__ . '/../app/models/Wishlist.php';
require_once __DIR__ . '/../app/models/Skill.php';
require_once __DIR__ . '/../app/models/Student.php';
require_once __DIR__ . '/../app/models/Pilot.php';
require_once __DIR__ . '/../app/models/CompanyFavorite.php';
require_once __DIR__ . '/../app/models/CompanyRating.php';
require_once __DIR__ . '/../app/models/AdminStats.php';

require_once __DIR__ . '/../app/models/User.php';
require_once __DIR__ . '/../app/models/Student.php';
require_once __DIR__ . '/../app/models/Pilot.php';



$config = require __DIR__ . '/../config/config.php';
App::init($config);

$router = new Router($config['app']['base_path'] ?? '');
$router->post('/wishlist/add', [WishlistController::class, 'add']);

require __DIR__ . '/../config/routes.php';

$method = $_SERVER['REQUEST_METHOD'] ?? 'GET';
$uri = $_SERVER['REQUEST_URI'] ?? '/';

$uri = strtok($uri, '?');
$basePath = $config['app']['base_path'] ?? '';

if ($basePath !== '' && str_starts_with($uri, $basePath)) {
    $uri = substr($uri, strlen($basePath));
}

if ($uri === '' || $uri === false) {
    $uri = '/';
}

$router->dispatch($method, $uri);