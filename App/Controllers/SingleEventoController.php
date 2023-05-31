<?php

namespace App\Controllers;

use App\Contracts\Controller;
use App\Models\Evento;
use App\SessionBag;
use App\View;
use Exception;

class SingleEventoController implements Controller
{
    public function get(): View
    {
        $evento = (new Evento())->getWhereId($_GET["id"] ?? 0);

        return (new View())
            ->render("eventos/show.html", ['evento' => $evento[0]]);
    }

    public function post(): never
    {
        try {
            (new Evento())->update($_POST, $_GET["id"]);
        } catch (Exception $e) {
            $this->get();
            die();
        }
        finally {
            SessionBag::putFlashMessage("Evento atualizado com sucesso!");
            header("Location: /eventos");
            die();
        }
    }

    public function delete(): never
    {
        die();
    }
}