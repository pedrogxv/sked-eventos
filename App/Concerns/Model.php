<?php

namespace App\Concerns;

abstract class Model
{
    // Nome do modelo (Usado como nome de tabela no banco de dados)
    public string $name = "";

    // Atributos do modelo
    protected array $attributes = [];
}