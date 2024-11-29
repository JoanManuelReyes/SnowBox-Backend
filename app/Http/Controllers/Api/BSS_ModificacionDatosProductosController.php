<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Services\BSS_ModificacionDatosProductos;

class BSS_ModificacionDatosProductosController extends Controller
{

    private BSS_ModificacionDatosProductos $bss_modificaciondatosproductos;

    public function __construct(BSS_ModificacionDatosProductos $bss_modificaciondatosproductos)
    {
        $this->bss_modificaciondatosproductos = $bss_modificaciondatosproductos;
    }

    public function modificarProducto(Request $request,$id)
    {
        $resultado = $this->bss_modificaciondatosproductos->ModificarProducto($request,$id);

        return response()->json(
            $resultado, 
            $resultado['status'] 
        );
    }


}