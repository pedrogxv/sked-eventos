<?php

namespace App\Controllers;

use App\View;

class EventoController extends Controller
{
    public function get(): View
    {
        return (new View())
            ->render("eventos/index.html");
    }

    public function post(): void
    {
        echo "POST";
        // TODO: Implement post() method.
    }
}