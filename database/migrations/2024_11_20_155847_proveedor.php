<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

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

        DB::statement("INSERT INTO proveedor (nombre,ruc,telefono,correo) VALUES ('JBL','20123456781','987654321','manuel_reyes_pillaca@outlook.es')");
        DB::statement("INSERT INTO proveedor (nombre,ruc,telefono,correo) VALUES ('Sony','20123456782','923456789','manuel_reyes_pillaca@outlook.es')");
        DB::statement("INSERT INTO proveedor (nombre,ruc,telefono,correo) VALUES ('Bose','20123456783','912345678','manuel_reyes_pillaca@outlook.es')");
        DB::statement("INSERT INTO proveedor (nombre,ruc,telefono,correo) VALUES ('Sennheiser','20123456784','934567890','manuel_reyes_pillaca@outlook.es')");
        DB::statement("INSERT INTO proveedor (nombre,ruc,telefono,correo) VALUES ('Samsung','20123456785','956789012','manuel_reyes_pillaca@outlook.es')");
        DB::statement("INSERT INTO proveedor (nombre,ruc,telefono,correo) VALUES ('Apple','20123456786','978901234','manuel_reyes_pillaca@outlook.es')");
        DB::statement("INSERT INTO proveedor (nombre,ruc,telefono,correo) VALUES ('Xiaomi','20123456787','901234567','manuel_reyes_pillaca@outlook.es')");
        DB::statement("INSERT INTO proveedor (nombre,ruc,telefono,correo) VALUES ('Huawei','20123456788','923456781','manuel_reyes_pillaca@outlook.es')");
        DB::statement("INSERT INTO proveedor (nombre,ruc,telefono,correo) VALUES ('Anker','20123456789','945678901','manuel_reyes_pillaca@outlook.es')");
        DB::statement("INSERT INTO proveedor (nombre,ruc,telefono,correo) VALUES ('Wacom','20123456790','967890123','manuel_reyes_pillaca@outlook.es')");
        DB::statement("INSERT INTO proveedor (nombre,ruc,telefono,correo) VALUES ('HP','20123456791','989012345','manuel_reyes_pillaca@outlook.es')");
        DB::statement("INSERT INTO proveedor (nombre,ruc,telefono,correo) VALUES ('Dell','20123456792','901234569','manuel_reyes_pillaca@outlook.es')");
        DB::statement("INSERT INTO proveedor (nombre,ruc,telefono,correo) VALUES ('ASUS','20123456793','923456784','manuel_reyes_pillaca@outlook.es')");
        DB::statement("INSERT INTO proveedor (nombre,ruc,telefono,correo) VALUES ('Kingston','20123456794','945678903','manuel_reyes_pillaca@outlook.es')");
        DB::statement("INSERT INTO proveedor (nombre,ruc,telefono,correo) VALUES ('Amazon','20123456795','967890125','manuel_reyes_pillaca@outlook.es')");
        DB::statement("INSERT INTO proveedor (nombre,ruc,telefono,correo) VALUES ('Google','20123456796','989012347','manuel_reyes_pillaca@outlook.es')");
        DB::statement("INSERT INTO proveedor (nombre,ruc,telefono,correo) VALUES ('Philips','20123456797','901234571','manuel_reyes_pillaca@outlook.es')");
        DB::statement("INSERT INTO proveedor (nombre,ruc,telefono,correo) VALUES ('TP-Link','20123456798','923456786','manuel_reyes_pillaca@outlook.es')");
        DB::statement("INSERT INTO proveedor (nombre,ruc,telefono,correo) VALUES ('Insta360','20123456799','945678905','manuel_reyes_pillaca@outlook.esm')");
        DB::statement("INSERT INTO proveedor (nombre,ruc,telefono,correo) VALUES ('GoPro','20123456800','967890127','manuel_reyes_pillaca@outlook.es')");
        DB::statement("INSERT INTO proveedor (nombre,ruc,telefono,correo) VALUES ('DJI','20123456801','989012349','manuel_reyes_pillaca@outlook.es')");
        DB::statement("INSERT INTO proveedor (nombre,ruc,telefono,correo) VALUES ('LG','20123456802','901234573','manuel_reyes_pillaca@outlook.es')");
        DB::statement("INSERT INTO proveedor (nombre,ruc,telefono,correo) VALUES ('Microsoft','20123456803','923456788','manuel_reyes_pillaca@outlook.es')");
        DB::statement("INSERT INTO proveedor (nombre,ruc,telefono,correo) VALUES ('CantonImportsPeru','20123456804','945678907','manuel_reyes_pillaca@outlook.es')");
        DB::statement("INSERT INTO proveedor (nombre,ruc,telefono,correo) VALUES ('Rode','20123456805','967890129','manuel_reyes_pillaca@outlook.es')");
        DB::statement("INSERT INTO proveedor (nombre,ruc,telefono,correo) VALUES ('Focusrite','20123456806','989012351','manuel_reyes_pillaca@outlook.es')");
        DB::statement("INSERT INTO proveedor (nombre,ruc,telefono,correo) VALUES ('TechImports','20123456807','901234575','manuel_reyes_pillaca@outlook.es')");


    }

    public function down(): void
    {
        Schema::dropIfExists('proveedor');
    }
};
