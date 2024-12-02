<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Services\ENT_Compra;

class ENT_CompraController extends Controller
{

    private ENT_Compra $ent_compra;

    public function __construct(ENT_Compra $ent_compra)
    {
        $this->ent_compra = $ent_compra;
    }

    public function listarTodosCompras()
    {
        return $this->ent_compra->listarCompras();
    }

    public function crearCompra(Request $request)
    {
        return $this->ent_compra->crearCompra($request);
    }

    public function actualizarEstadoCompra(Request $request, $id)
    {
        return $this->ent_compra->actualizarEstadoCompra($request, $id);
    }
}