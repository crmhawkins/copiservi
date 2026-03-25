<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('usuarios', function (Blueprint $table) {
            $table->id();
            $table->string('usuario', 240)->unique();
            $table->integer('copias')->default(0);
            $table->date('ingreso');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('usuarios');
    }
};

