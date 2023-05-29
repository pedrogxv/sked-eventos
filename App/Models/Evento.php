<?php

namespace App\Models;

use App\Concerns\Model;

class Evento extends Model
{
    public string $name = 'eventos';

    protected array $attributes = [
        'id' ,'titulo', 'descricao', 'inicio', 'termino', 'updated_at', 'created_at', 'deleted_at'
    ];
}