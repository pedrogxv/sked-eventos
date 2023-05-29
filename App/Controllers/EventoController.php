<?php

namespace App\Controllers;

use App\Contracts\Controller;
use App\Models\Evento;
use App\View;

class EventoController implements Controller
{
    public function get(): View
    {
        $eventos = (new Evento())->all();

        return (new View())
            ->render("eventos/index.html", ['eventos' => $eventos]);
    }

    public function post(): never
    {
        (new Evento())->save($_POST);
        var_dump($_POST);
//        header("Location: /eventos");
        die();
    }
}