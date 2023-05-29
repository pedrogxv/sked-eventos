<?php

namespace App\Database\Migrations;

use App\Concerns\Migration;
use App\Models\Evento;

class CreateEventosTable extends Migration
{
    protected string $model = Evento::class;

    protected array $attributes = [
        'id' => ["bigint", "PRIMARY KEY", "AUTO_INCREMENT"],
        'titulo' => ["varchar(255)", "not null"],
        'descricao' => ["text"],
        'inicio' => ["datetime", "not null"],
        'termino' => ["datetime", "not null"],
        'created_at' => ["datetime", "not null", "DEFAULT CURRENT_TIMESTAMP()"],
        'updated_at' => ["datetime"],
        'deleted_at' => ["datetime"],
    ];
}