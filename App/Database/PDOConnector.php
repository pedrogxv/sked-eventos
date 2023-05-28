<?php

namespace App\Database;

use PDO;
use PDOException;

class PDOConnector
{
    public static function getConnector(): ?PDO
    {
        try {
            $connector = new PDO(
                "mysql:host={$_ENV['DB_HOST']};dbname={$_ENV['DB_NAME']}", $_ENV["DB_USERNAME"], $_ENV["DB_PASSWORD"]
            );
            $connector->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch (PDOException $e) {
            echo "Erro na conexão: " . $e->getMessage();
        }

        return $connector ?? null;
    }
}