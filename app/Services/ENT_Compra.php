<?php

namespace App\Services;

use App\Models\Compra;
use Illuminate\Http\Request;

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
}