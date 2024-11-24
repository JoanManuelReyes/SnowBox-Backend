<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('usuario', function (Blueprint $table) {
            $table->engine="InnoDB";
            $table->id();
            $table->string('nombre_completo', 50);
            $table->char('dni', 8);
            $table->string('contrasenia', 100);
            $table->char('telefono', 9);
            $table->char('estado', 1);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('usuario');
    }
};
