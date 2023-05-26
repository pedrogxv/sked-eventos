<?php

use App\RouteLoader;
use App\Controllers\EventoController;

RouteLoader::register('/', (new EventoController()));