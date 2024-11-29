<?php

namespace App\Services;

use App\Models\Devolucion;

class ENT_Devolucion {

    public function listarDevoluciones()
    {   
        $devolucionConsulta = Devolucion::all()->toArray();
        $devoluciones = array_filter($devolucionConsulta, function ($devoluciones){
            return $devoluciones['tipo'] == 'Devolución';
        });
        return array_values($devoluciones);
    }
}