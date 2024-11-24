<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('proveedor', function (Blueprint $table) {
            $table->engine="InnoDB";
            $table->id();;
            $table->string('nombre', 50);
            $table->char('ruc', 11);
            $table->char('telefono', 9);
            $table->string('correo', 35);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('proveedor');
    }
};
