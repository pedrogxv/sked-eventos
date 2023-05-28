<?php

require __DIR__ . '/vendor/autoload.php';

require_once 'routes/app.php';

use App\Database\MigrationLoader;
use App\RouteLoader;

// Configuração do Dotenv
$dotenv = Dotenv\Dotenv::createImmutable(__DIR__);
$dotenv->safeLoad();

// Executa as migrations necessárias no banco
MigrationLoader::executeMigrations();

// Configuração e execução da rota acionada
RouteLoader::loadRoute();
