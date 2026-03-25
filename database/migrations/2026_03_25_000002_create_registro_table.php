<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('registro', function (Blueprint $table) {
            $table->id();
            $table->string('usuario', 240);
            $table->string('accion', 240);
            $table->text('notas');
            $table->dateTime('fecha');
            $table->foreignId('admin_id')->nullable()->constrained('admins')->nullOnDelete();

            $table->index(['usuario', 'fecha']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('registro');
    }
};

