<?php

namespace App\Services;

use App\Models\Devolucion;
use Illuminate\Http\Request;

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
}