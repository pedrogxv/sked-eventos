<?php

namespace App\Models;

use App\Concerns\Model;

class Evento extends Model
{
    public string $name = 'eventos';

    protected array $fillable = [
        'titulo', 'descricao', 'inicio', 'termino',
    ];

    protected array $rules = [
        'titulo' => ["string", "min:5", "required"],
        'descricao' => ["string"],
        'inicio' => ["datetime", "after:hoje", "required"],
        'termino' => ["datetime", "after:inicio", "required"],
    ];
}