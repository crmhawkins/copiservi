<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('admins', function (Blueprint $table) {
            $table->id();
            $table->string('usuario', 240)->unique();
            $table->string('password', 240);
            $table->integer('nivel')->default(0);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('admins');
    }
};

