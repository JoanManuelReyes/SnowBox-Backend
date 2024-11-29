<?php

namespace App\Services;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\Producto;
use App\Models\Registro;
use App\Models\Proveedor;
use App\Models\Solicitud;

class BSS_RevisionProductosRecibidos {
    
    public function RegistrarProducto(Request $request) {
        $validacion = Validator::make($request->all(), [
            'id' => 'required|unique:producto,id',
            'nombre' => 'required|unique:producto,nombre',
            'proveedor' => 'required|exists:proveedor,id',
            'descripcion' => 'required',
            'entradas' => 'required',
        ]);

        if ($validacion->fails()) {
            return [
                'status' => 400,
                'message' => 'Error en validar',
                'errors' => $validacion->errors(),
            ];
        }

        $producto = Producto::create([
            'nombre' => $request->nombre,
            'descripcion' => $request->descripcion,
            'stock' => $request->entradas,
            'proveedor_id' => $request->proveedor,
        ]);

        if (!$producto) {
            return [
                'status' => 500,
                'message' => 'Error al crear el producto',
            ];
        }

        $registro = Registro::create([
            'fecha' => now(),
            'tipo' => 'Entrada',
            'cantidad' => $request->entradas,
            'producto_id' => $producto->id,
        ]);
    
        if (!$registro) {
            return [
                'status' => 500,
                'message' => 'Producto creado, pero falló al registrar la entrada',
            ];
        }

        return [
            'status' => 200,
            'message' => 'Producto registrado correctamente ',
        ];

    }
}