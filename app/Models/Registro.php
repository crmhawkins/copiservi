<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Registro extends Model
{
    protected $table = 'registro';

    protected $fillable = [
        'usuario',
        'accion',
        'notas',
        'fecha',
        'admin_id',
    ];

    protected $casts = [
        'fecha' => 'datetime',
        'admin_id' => 'integer',
    ];

    public $timestamps = false;
}

