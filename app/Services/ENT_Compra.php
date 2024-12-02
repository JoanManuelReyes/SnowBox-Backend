<?php

namespace App\Services;

use App\Models\Compra;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ENT_Compra {

    public function listarCompras()
    {   
        $compraConsulta = Compra::all()->toArray();
        $compras = array_filter($compraConsulta, function ($compras){
            return $compras['tipo'] == 'Compra';
        });
        return array_values($compras);
    }

    public function crearCompra(Request $request){
        return Compra::create([
            'usuario_id' => $request->id_usuario,
            'producto_id' => $request->id_producto,
            'tipo' => 'Compra',
            'descripcion' => $request->descripcion,
            'cantidad' => $request->cantidad,
            'fecha' => now(),
            'estado' => 'En espera',
        ]);
    }

    public function actualizarEstadoCompra(Request $request, $id){
        $validacion = Validator::make($request->all(), [
            'estado' => 'required',
        ]);

        if ($validacion->fails()) {
            return [
                'status' => 400,
                'message' => 'Error en validar',
                'errors' => $validacion->errors(),
            ];
        }

        $compra = Compra::find($id);
        if (!$compra) {
            return [
                'status' => 404,
                'message' => 'Compra no encontrada',
            ];
        }
        $compra->estado = $request->estado;
        $compra->save();
        return [
            'status' => 200,
            'message' => 'Estado de compra actualizado correctamente',
        ];
    }
}