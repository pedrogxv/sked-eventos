<?php

use App\RouteLoader;
use App\Controllers\EventoController;

RouteLoader::registerSingleAction('GET', '/', new EventoController(), 'get');
RouteLoader::register('/eventos', (new EventoController()));
