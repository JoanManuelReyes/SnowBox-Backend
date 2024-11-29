<?php

namespace App\Services;

use App\Models\Compra;

class ENT_Compra {

    public function listarCompras()
    {   
        $compraConsulta = Compra::all()->toArray();
        $compras = array_filter($compraConsulta, function ($compras){
            return $compras['tipo'] == 'Devolución';
        });
        return array_values($compras);
    }
}