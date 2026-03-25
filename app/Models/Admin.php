<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Hash;

class Admin extends Model
{
    protected $table = 'admins';

    protected $fillable = [
        'usuario',
        'password',
        'nivel',
    ];

    public $timestamps = false;

    public function checkPassword(string $plain): bool
    {
        $stored = (string) $this->password;

        // Compatibilidad con el sistema antiguo (MD5).
        if (preg_match('/^[a-f0-9]{32}$/i', $stored)) {
            return hash_equals(strtolower($stored), md5($plain));
        }

        // Para admins nuevos (bcrypt/argon via Hash).
        return Hash::check($plain, $stored);
    }
}

