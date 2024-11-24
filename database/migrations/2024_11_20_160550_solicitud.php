<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('solicitud', function (Blueprint $table) {
            $table->engine="InnoDB";
            $table->id();
            $table->foreignId('usuario_id')
                ->constrained('usuario')
                ->onDelete('cascade');
            $table->foreignId('producto_id')
                ->constrained('producto')
                ->onDelete('cascade');
            $table->string('tipo', 20);
            $table->string('descripcion', 250);
            $table->integer('cantidad');
            $table->date('fecha');
            $table->string('estado', 50);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('solicitud');
    }
};
