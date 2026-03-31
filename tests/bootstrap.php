<?php
declare(strict_types=1);

ini_set('display_errors', '1');
error_reporting(E_ALL);

require_once __DIR__ . '/../app/core/App.php';
require_once __DIR__ . '/../app/core/DB.php';

require_once __DIR__ . '/../app/models/CompanyRating.php';

$config = require __DIR__ . '/../config/config.php';
App::init($config); 