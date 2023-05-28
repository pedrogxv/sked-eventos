<?php

namespace App\Database;

class MigrationLoader
{
    // Executa todas as migrations, através dos arquivos de classe no diretório "Migrations/"
    public static function executeMigrations(): void
    {
        $namespace = "App\\Database\\Migrations\\";

        // Diretório onde estão as classes
        $directory = dirname(__DIR__) . "\\Database\\Migrations\\";

        // Obter uma lista de arquivos no diretório
        $files = scandir($directory);

        foreach ($files as $file) {
            // Verificar se é um arquivo PHP
            if (pathinfo($file, PATHINFO_EXTENSION) === 'php') {
                // Incluir o arquivo
                require_once $directory . $file;

                // Obter o nome do arquivo sem a extensão
                $className = $namespace . pathinfo($file, PATHINFO_FILENAME);

                // Verificar se a classe existe
                if (class_exists($className)) {
                    // Instanciar a classe
                    $instance = new $className();

                    // Checando se o método createTable existe na classe
                    if (method_exists($instance, "createTable")) {
                        $instance->createTable();
                    }
                }
            }
        }
    }
}