<?php

namespace App\Concerns;

use App\Database\PDOConnector;

abstract class Migration
{
    // model class
    protected string $model;

    protected function getModelInstance(): Model
    {
        return new $this->model();
    }

    protected array $attributes = [];

    // Cria a tabela no banco utilizando PDO
    public function createTable(): void
    {
        // montando o comando sql conforme os atributos definidos na classe herdada
        $statement = "CREATE TABLE IF NOT EXISTS " . $this->getModelInstance()->name . " (";

        foreach ($this->attributes as $field => $attribute) {
            $statement .= "$field " . implode(" ", $attribute) . ", ";
        }

        $statement = rtrim($statement, ", ") . ");";

        PDOConnector::getConnector()->exec($statement);
    }
}