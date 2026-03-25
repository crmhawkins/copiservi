<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Usuario extends Model
{
    protected $table = 'usuarios';

    protected $fillable = [
        'usuario',
        'copias',
        'ingreso',
    ];

    protected $casts = [
        'copias' => 'integer',
        'ingreso' => 'date',
    ];

    public $timestamps = false;
}

