<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Services\ENT_Producto;

class ENT_ProductoController extends Controller
{

    private ENT_Producto $ent_producto;

    public function __construct(ENT_Producto $ent_producto)
    {
        $this->ent_producto = $ent_producto;
    }

    public function listarTodosProductos()
    {
        return $this->ent_producto->listarProductos();
    }    
}
