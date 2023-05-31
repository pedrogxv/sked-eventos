<?php

use App\Controllers\SingleEventoController;
use App\RouteLoader;
use App\Controllers\EventoController;

RouteLoader::registerAction('GET', '/', new EventoController(), 'get');
RouteLoader::register('/eventos', new EventoController());
RouteLoader::register('/eventos/unique', new SingleEventoController());
