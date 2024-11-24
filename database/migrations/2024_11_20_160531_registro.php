<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('registro', function (Blueprint $table) {
            $table->engine="InnoDB";
            $table->id();
            $table->date('fecha');
            $table->integer('cantidad');
            $table->string('tipo', 10);
            $table->foreignId('producto_id')
                ->constrained('producto')
                ->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('registro');
    }
};
