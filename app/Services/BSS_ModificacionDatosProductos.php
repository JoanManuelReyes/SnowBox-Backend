<?php

namespace App\Services;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\Producto;
use App\Http\Controllers\Api\ENT_ProductoController;
use App\Models\Registro;

class BSS_ModificacionDatosProductos {

    public function ModificarProducto(Request $request,$id) {
        $validacion = Validator::make($request->all(), [
            'id' => 'required|exists:producto,id',
            'nombre' => 'required',
            'proveedor' => 'required|exists:proveedor,id',
            'descripcion' => 'required',
            'entradas' => 'required',
            'salidas' => 'required',
        ]);

        if ($validacion->fails()) {
            return [
                'status' => 400,
                'message' => 'Error en validar',
                'errors' => $validacion->errors(),
            ];
        }

        $producto = Producto::find($id);
        if (!$producto) {
            return [
                'status' => 404,
                'message' => 'Producto no encontrado',
            ];
        }
        
        app(ENT_ProductoController::class)->modificarDatosProducto($request, $producto);

        $registro = Registro::all()->toArray();
        
        $entrada = array_filter($registro, function ($entradas){
            return $entradas['tipo'] == 'Entrada';
        });

        $salida = array_filter($registro, function ($salidas){
            return $salidas['tipo'] == 'Salida';
        });

        $entradasActuales = $producto->calcularEntradas($entrada);

        $entradaActual = array_filter($entradasActuales, function ($entrada) use ($producto) {
            return $entrada['producto_id'] === $producto->id;
        });

        $entradaCantidad = count($entradaActual) > 0 
            ? array_values($entradaActual)[0]['cantidad'] 
            : 0;

        $salidasActuales = $producto->calcularSalidas($salida);

        $salidaActual = array_filter($salidasActuales, function ($salida) use ($producto) {
            return $salida['producto_id'] === $producto->id;
        });

        $salidaCantidad = count($salidaActual) > 0 
            ? array_values($salidaActual)[0]['cantidad'] 
            : 0;

        if($request->entradas<$salidaCantidad){
            return [
                'status' => 400,
                'message' => 'Error en validar',
                'errors' => [
                    'entradas' => [
                        "El valor de las entradas no puede ser menor a las salidas.",
                    ],
                ],
            ];
        }

        if ($request->entradas < $entradaCantidad) {
            return [
                'status' => 400,
                'message' => 'Error en validar',
                'errors' => [
                    'entradas' => [
                        "El valor de entradas debe ser mayor a $entradaCantidad.",
                    ],
                ],
            ];
        }

        if ($request->entradas > $entradaCantidad) {
            Registro::create([
                'fecha' => now(),
                'tipo' => 'Entrada',
                'cantidad' => $request->entradas-$entradaCantidad,
                'producto_id' => $producto->id,
            ]);
        }

        if ($request->salidas < $salidaCantidad) {
            return [
                'status' => 400,
                'message' => 'Error en validar',
                'errors' => [
                    'salidas' => [
                        "El valor de salidas debe ser mayor a $salidaCantidad.",
                    ],
                ],
            ];
        }
        if ($request->salidas > $salidaCantidad){
            Registro::create([
                'fecha' => now(),
                'tipo' => 'Salida',
                'cantidad' => $request->salidas-$salidaCantidad,
                'producto_id' => $producto->id,
            ]);
        }
        
        return [
            'status' => 200,
            'message' => 'Producto modificado correctamente',
        ];
    }
}