<?php

namespace App\Services;

use App\Models\Producto;
use Illuminate\Http\Request;

class ENT_Producto {

    public function listarProductos()
    {   
        $producto = Producto::all();
        return $producto;
    }

    public function solicitarDatosProducto($id)
    {   
        return Producto::find($id);
    }

    public function crearProducto(Request $request){
        return Producto::create([
            'nombre' => $request->nombre,
            'descripcion' => $request->descripcion,
            'stock' => $request->entradas,
            'proveedor_id' => $request->proveedor,
        ]);
    }

    public function modificarDatosProducto(Request $request, Producto $producto){
        return $producto->nombre = $request->nombre;
        $producto->descripcion = $request->descripcion;
        $producto->stock = $request->entradas-$request->salidas;
        $producto->proveedor_id= $request->proveedor;
        $producto->save();
    }
}