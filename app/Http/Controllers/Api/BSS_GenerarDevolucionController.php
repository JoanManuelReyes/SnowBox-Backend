<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Services\BSS_GenerarDevolucion;

class BSS_GenerarDevolucionController extends Controller
{

    private BSS_GenerarDevolucion $bss_generardevolucion;

    public function __construct(BSS_GenerarDevolucion $bss_generardevolucion)
    {
        $this->bss_generardevolucion = $bss_generardevolucion;
    }

    public function registrarDevolucion(Request $request)
    {
        $resultado = $this->bss_generardevolucion->RegistrarDevolucion($request);

        return response()->json(
            $resultado, 
            $resultado['status'] 
        );
    }

}