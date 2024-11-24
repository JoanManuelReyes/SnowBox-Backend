<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Services\ENT_Producto;

class productoController extends Controller
{

    private ENT_Producto $ent_producto;

    public function __construct(ENT_Producto $ent_producto)
    {
        $this->ent_producto = $ent_producto;
    }


    public function listarTabla()
    {
        $productos = $this->ent_producto->ListarProductosInv('Normal');
        return response()->json($productos);
    }

    public function listarTablaRestock()
    {
        $productos = $this->ent_producto->ListarProductosInv('Restock');
        return response()->json($productos);
    }

    public function registrarProducto(Request $request)
    {
        $resultado = $this->ent_producto->RegistrarProducto($request);

        return response()->json(
            $resultado, // Datos del servicio
            $resultado['status'] // Código de estado HTTP
        );
    }

    public function modificarProducto(Request $request,$id)
    {
        $resultado = $this->ent_producto->ModificarProducto($request,$id);

        return response()->json(
            $resultado, // Datos del servicio
            $resultado['status'] // Código de estado HTTP
        );
    }


}
