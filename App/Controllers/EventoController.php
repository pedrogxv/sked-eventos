<?php

namespace App\Controllers;

use App\Contracts\Controller;
use App\View;

class EventoController implements Controller
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