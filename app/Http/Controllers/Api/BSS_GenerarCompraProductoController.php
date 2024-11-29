<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Services\BSS_GenerarCompraProducto;

class BSS_GenerarCompraProductoController extends Controller
{

    private BSS_GenerarCompraProducto $bss_generarcompraproducto;

    public function __construct(BSS_GenerarCompraProducto $bss_generarcompraproducto)
    {
        $this->bss_generarcompraproducto = $bss_generarcompraproducto;
    }



}