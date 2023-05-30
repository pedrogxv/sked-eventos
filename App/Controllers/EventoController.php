<?php

namespace App\Controllers;

use App\Contracts\Controller;
use App\Exceptions\ValidatorException;
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
        try {
            $salvo = (new Evento())->save($_POST);

            if ($salvo) {
                header("Location: /eventos");
                die();
            }
        } catch (ValidatorException $e) {
        } finally {
            $this->get();
            die();
        }
    }
}