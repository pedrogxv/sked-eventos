<?php

namespace App\Contracts;

use App\View;

interface Controller
{
    public function get(): View;
    public function post(): never;
    public function delete(): never;
}