<?php

namespace App\Controllers;

use App\View;

abstract class Controller
{
    abstract public function get(): View;
    abstract public function post(): void;
}