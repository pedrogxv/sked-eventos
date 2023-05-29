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
        var_dump($_POST);
        (new Evento())->save($_POST);
//        header("Location: /eventos");
        die();
    }
}