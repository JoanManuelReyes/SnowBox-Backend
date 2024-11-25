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

        DB::statement("INSERT INTO proveedor (nombre,ruc,telefono,correo) VALUES ('JBL','20123456781','987654321','negocios@JBL.com')");
        DB::statement("INSERT INTO proveedor (nombre,ruc,telefono,correo) VALUES ('Sony','20123456782','923456789','negocios@Sony.com')");
        DB::statement("INSERT INTO proveedor (nombre,ruc,telefono,correo) VALUES ('Bose','20123456783','912345678','negocios@Bose.com')");
        DB::statement("INSERT INTO proveedor (nombre,ruc,telefono,correo) VALUES ('Sennheiser','20123456784','934567890','negocios@sennheiser.com')");
        DB::statement("INSERT INTO proveedor (nombre,ruc,telefono,correo) VALUES ('Samsung','20123456785','956789012','negocios@samsung.com')");
        DB::statement("INSERT INTO proveedor (nombre,ruc,telefono,correo) VALUES ('Apple','20123456786','978901234','negocios@apple.com')");
        DB::statement("INSERT INTO proveedor (nombre,ruc,telefono,correo) VALUES ('Xiaomi','20123456787','901234567','negocios@xiamoi.com')");
        DB::statement("INSERT INTO proveedor (nombre,ruc,telefono,correo) VALUES ('Huawei','20123456788','923456781','negocios@huawei.com')");
        DB::statement("INSERT INTO proveedor (nombre,ruc,telefono,correo) VALUES ('Anker','20123456789','945678901','negocios@anker.com')");
        DB::statement("INSERT INTO proveedor (nombre,ruc,telefono,correo) VALUES ('Wacom','20123456790','967890123','negocios@wacom.com')");
        DB::statement("INSERT INTO proveedor (nombre,ruc,telefono,correo) VALUES ('HP','20123456791','989012345','negocios@hp.com')");
        DB::statement("INSERT INTO proveedor (nombre,ruc,telefono,correo) VALUES ('Dell','20123456792','901234569','negocios@dell.com')");
        DB::statement("INSERT INTO proveedor (nombre,ruc,telefono,correo) VALUES ('ASUS','20123456793','923456784','negocios@asus.com')");
        DB::statement("INSERT INTO proveedor (nombre,ruc,telefono,correo) VALUES ('Kingston','20123456794','945678903','negocios@kingston.com')");
        DB::statement("INSERT INTO proveedor (nombre,ruc,telefono,correo) VALUES ('Amazon','20123456795','967890125','negocios@amazon.com')");
        DB::statement("INSERT INTO proveedor (nombre,ruc,telefono,correo) VALUES ('Google','20123456796','989012347','negocios@google.com')");
        DB::statement("INSERT INTO proveedor (nombre,ruc,telefono,correo) VALUES ('Philips','20123456797','901234571','negocios@philips.com')");
        DB::statement("INSERT INTO proveedor (nombre,ruc,telefono,correo) VALUES ('TP-Link','20123456798','923456786','negocios@tplink.com')");
        DB::statement("INSERT INTO proveedor (nombre,ruc,telefono,correo) VALUES ('Insta360','20123456799','945678905','negocios@insta360.com')");
        DB::statement("INSERT INTO proveedor (nombre,ruc,telefono,correo) VALUES ('GoPro','20123456800','967890127','negocios@gopro.com')");
        DB::statement("INSERT INTO proveedor (nombre,ruc,telefono,correo) VALUES ('DJI','20123456801','989012349','negocios@dji.com')");
        DB::statement("INSERT INTO proveedor (nombre,ruc,telefono,correo) VALUES ('LG','20123456802','901234573','negocios@lg.com')");
        DB::statement("INSERT INTO proveedor (nombre,ruc,telefono,correo) VALUES ('Microsoft','20123456803','923456788','negocios@microsoft.com')");
        DB::statement("INSERT INTO proveedor (nombre,ruc,telefono,correo) VALUES ('CantonImportsPeru','20123456804','945678907','negocios@cantonimportsperu.com')");
        DB::statement("INSERT INTO proveedor (nombre,ruc,telefono,correo) VALUES ('Rode','20123456805','967890129','negocios@rode.com')");
        DB::statement("INSERT INTO proveedor (nombre,ruc,telefono,correo) VALUES ('Focusrite','20123456806','989012351','negocios@focusrite.com')");
        DB::statement("INSERT INTO proveedor (nombre,ruc,telefono,correo) VALUES ('TechImports','20123456807','901234575','negocios@techimports.com')");


    }

    public function down(): void
    {
        Schema::dropIfExists('proveedor');
    }
};
