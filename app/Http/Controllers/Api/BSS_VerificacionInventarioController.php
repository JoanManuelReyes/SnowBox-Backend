<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Services\BSS_VerificacionInventario;

class BSS_VerificacionInventarioController extends Controller
{

    private BSS_VerificacionInventario $bss_verificacioninventario;

    public function __construct(BSS_VerificacionInventario $bss_verificacioninventario)
    {
        $this->bss_verificacioninventario = $bss_verificacioninventario;
    }

    public function listarTabla()
    {
        $productos = $this->bss_verificacioninventario->ListarProductosInv('Normal');
        return response()->json($productos);
    }

    public function listarTablaRestock()
    {
        $productos = $this->bss_verificacioninventario->ListarProductosInv('Restock');
        return response()->json($productos);
    }


}