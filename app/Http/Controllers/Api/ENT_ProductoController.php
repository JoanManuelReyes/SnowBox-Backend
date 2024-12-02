<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Services\ENT_Producto;
use App\Models\Producto;

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

    public function solicitarDatosProducto($id)
    {
        return $this->ent_producto->solicitarDatosProducto($id);
    }

    public function crearProducto(Request $request)
    {
        return $this->ent_producto->crearProducto($request);
    }

    public function modificarDatosProducto(Request $request, $id)
    {
        return $this->ent_producto->modificarDatosProducto($request, $id);
    }

    public function listarReportes()
    {
        return $this->ent_producto->listarRegistrosyDevoluciones();
    }    

}
