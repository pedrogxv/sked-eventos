<?php

namespace App\Concerns;

use App\Database\PDOConnector;
use PDO;

abstract class Model
{
    // Nome do modelo (Usado como nome de tabela no banco de dados)
    public string $name = "";

    // Atributos do modelo
    protected array $attributes = [];

    public function all(): array
    {
        $query = "SELECT * FROM $this->name";

        $con = PDOConnector::getConnector()->prepare($query);
        $con->execute();

        return $con->fetchAll(PDO::FETCH_ASSOC) ?: [];
    }
}