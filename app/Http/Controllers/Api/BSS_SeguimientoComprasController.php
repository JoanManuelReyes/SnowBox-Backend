<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Services\BSS_SeguimientoCompras;

class BSS_SeguimientoComprasController extends Controller
{

    private BSS_SeguimientoCompras $bss_seguimientocompras;

    public function __construct(BSS_SeguimientoCompras $bss_seguimientocompras)
    {
        $this->bss_seguimientocompras = $bss_seguimientocompras;
    }



}