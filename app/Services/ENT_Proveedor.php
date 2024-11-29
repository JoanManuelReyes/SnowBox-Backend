<?php

namespace App\Services;

use App\Models\Proveedor;

class ENT_Proveedor {

    public function listarProveedores()
    {   
        $proveedores = Proveedor::all();
        return $proveedores;
    }
}