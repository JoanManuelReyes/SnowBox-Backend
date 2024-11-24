<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('producto', function (Blueprint $table) {
            $table->engine = "InnoDB";
            $table->id();
            $table->string('nombre', 35);
            $table->string('descripcion', 150);
            $table->integer('stock');
            $table->foreignId('proveedor_id')
                ->constrained('proveedor')
                ->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('producto');
    }
};

