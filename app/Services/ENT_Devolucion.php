<?php

namespace App\Services;

use App\Models\Devolucion;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ENT_Devolucion {

    public function listarDevoluciones()
    {   
        $devolucionConsulta = Devolucion::all()->toArray();
        $devoluciones = array_filter($devolucionConsulta, function ($devoluciones){
            return $devoluciones['tipo'] == 'Devolución';
        });
        return array_values($devoluciones);
    }

    public function crearDevolucion(Request $request){
        return Devolucion::create([
            'usuario_id' => $request->id_usuario,
            'producto_id' => $request->id_producto,
            'tipo' => 'Devolución',
            'descripcion' => $request->descripcion,
            'cantidad' => $request->cantidad,
            'fecha' => now(),
            'estado' => 'En espera',
        ]);
    }

    public function actualizarEstadoDevolucion(Request $request, $id){
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

        $devolucion = Devolucion::find($id);
        if (!$devolucion) {
            return [
                'status' => 404,
                'message' => 'Compra no encontrada',
            ];
        }
        $devolucion->estado = $request->estado;
        $devolucion->save();
        return [
            'status' => 200,
            'message' => 'Estado de devolución actualizado correctamente',
        ];
    }
}