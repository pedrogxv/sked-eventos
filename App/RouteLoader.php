<?php

namespace App;

use App\Contracts\Controller;
use ReflectionClass;

final class RouteLoader
{
    private static array $routes = [];

    public static function loadRoute(): void
    {
        $route_name = $_SERVER["PATH_INFO"] ?? "/";
        $req_method = $_SERVER['REQUEST_METHOD'];

        if (!array_key_exists($route_name, self::$routes)) {
            die("Não foi encontrada rotas para esta requisição: \'$route_name\'.");
        }

        $route = self::$routes[$route_name];

        if (!array_key_exists($req_method, $route)) {
            die("Não foi encontrado uma ação para o método \'$req_method\' nesta rota.");
        }

        // executando a funcao que corresponde com a rota e o método da requisicao
        $route[$req_method]->invoke(
            $route['class']->newInstance()
        );

        // Limpa mochila da sessão para não deixar resíduos
        SessionBag::clearBag();
    }

    /** Registra uma acao na rota [GET, POST, UPDATE, etc...] */
    public static function registerAction(string $action, string $route, object $controller, string $functionName): void
    {
        if (!isset(self::$routes[$route])) self::$routes[$route] = ["class" => new ReflectionClass($controller)];

        self::$routes[$route] += [
            strtoupper($action) => (new ReflectionClass($controller))->getMethod(
                $functionName
            ),
        ];
    }

    /** Registrando todos os métodos de um controller automaticamente */
    public static function register(string $route, Controller $controller): void
    {
        $class = new ReflectionClass($controller);
        $functions = $class->getMethods();

        // Registrando cada funcao do controller em seu respectivo metodo (GET, POST, DELETE, etc)
        foreach ($functions as $function) {
            self::registerAction(
                action: $function->getName(),
                route: $route,
                controller: $controller,
                functionName: $function->getName(),
            );
        }
    }
}