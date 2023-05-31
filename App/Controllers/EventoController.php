<?php

namespace App\Controllers;

use App\Contracts\Controller;
use App\Exceptions\ValidatorException;
use App\Models\Evento;
use App\SessionBag;
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
                SessionBag::putFlashMessage("Evento adicionado com sucesso!");

                header("Location: /eventos");
                die();
            }
        } catch (ValidatorException $e) {
        } finally {
            // colocando os valores que o usuário passou anteriormente
            SessionBag::putFormDataValue($_POST);
            // caso não tenha conseguido salvar ele é redirecionado para a rota "get"
            $this->get();
            die();
        }
    }

    public function delete(): never
    {
        (new Evento())->delete($_GET['id']);
        SessionBag::putFlashMessage("Evento deletado com sucesso!");
        die();
    }
}