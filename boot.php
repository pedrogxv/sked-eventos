<?php

require __DIR__ . '/vendor/autoload.php';

require_once 'routes/app.php';

use App\RouteLoader;

$dotenv = Dotenv\Dotenv::createImmutable(__DIR__);
$dotenv->safeLoad();

RouteLoader::loadRoute();
