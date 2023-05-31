<?php

namespace App;

use Twig\Environment;
use Twig\Loader\FilesystemLoader;

final class View
{
    private FilesystemLoader $loader;
    private Environment $twig;

    public function __construct()
    {
        // Configuração do Twig
        $this->loader = new FilesystemLoader(dirname(__DIR__) . "\\views");
        $this->twig = new Environment($this->loader, [
            'cache' => 'cache',
            'auto_reload' => true,
        ]);

        // Adicionando a variável de sessão ao escopo global do Twig
        $this->twig->addGlobal('session', $_SESSION);
    }

    // renderiza o arquivo solicitado
    public function render(string $view_path, array $data = []): View
    {
        echo $this->twig->render($view_path, $data);

        return $this;
    }
}