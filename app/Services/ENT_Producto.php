<?php

namespace App\Services;

use App\Models\Producto;

class ENT_Producto {

    public function listarProductos()
    {   
        $producto = Producto::all();
        return $producto;
    }
}