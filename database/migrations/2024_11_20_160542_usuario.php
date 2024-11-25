<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

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

        DB::statement("INSERT INTO Usuario (nombre_completo,dni,contrasenia,telefono,estado) VALUES ('José Luis Morales','18523367','3ddb7cffe21964c54f62ea0a85cf29ff2578d7be8f6378020f038aa70c2c1231','947141321','1')");
        DB::statement("INSERT INTO Usuario (nombre_completo,dni,contrasenia,telefono,estado) VALUES ('Lucía Rodríguez','23456789','641a8cb7c13d3917151cb13d1c942c76d91a59a5bf3f53ee67990380dd68d8bd','976543210','1')");
        DB::statement("INSERT INTO Usuario (nombre_completo,dni,contrasenia,telefono,estado) VALUES ('Miguel Ángel Ruiz','34567890','b72f711bb9efdffe85b847933f4c6fa6f5182cd4e6a384446e69b53ede9ed01f','965432109','1')");
        DB::statement("INSERT INTO Usuario (nombre_completo,dni,contrasenia,telefono,estado) VALUES ('Mariana Salas','45678901','16892d8766f61401e4e66a5fe669eecc0c64ba2fcd32f34ac59a5f2dde050223','954321098','1')");
        DB::statement("INSERT INTO Usuario (nombre_completo,dni,contrasenia,telefono,estado) VALUES ('Ricardo Gómez','56789012','926fb15b032f6fd5dda1ec0c788ffe4436fc7ff77dd0217a6160f128cc69443e','943210987','1')");
        DB::statement("INSERT INTO Usuario (nombre_completo,dni,contrasenia,telefono,estado) VALUES ('Carmen Castillo','67890123','bbbb36be904f7925aa3701a35e5d1ac0d35ca7d9389437e73dcd173fb17e9010','932109876','1')");
        DB::statement("INSERT INTO Usuario (nombre_completo,dni,contrasenia,telefono,estado) VALUES ('Fernando Herrera','78901234','4fb9966c6cc48c67487d118c60477764975a2acb745d96a57aa84ead8d1f6323','921098765','1')");
        DB::statement("INSERT INTO Usuario (nombre_completo,dni,contrasenia,telefono,estado) VALUES ('Patricia Fernández','89012345','9c56cc51b374c3ba189210d5b6d4bf57790d351c96c47c02190ecf1e430635ab','910987654','1')");
    }

    public function down(): void
    {
        Schema::dropIfExists('usuario');
    }
};
