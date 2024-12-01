<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Services\BSS_RevisionProductosRecibidos;

class BSS_RevisionProductosRecibidosController extends Controller
{

    private BSS_RevisionProductosRecibidos $bss_revisionproductosrecibidos;

    public function __construct(BSS_RevisionProductosRecibidos $bss_revisionproductosrecibidos)
    {
        $this->bss_revisionproductosrecibidos = $bss_revisionproductosrecibidos;
    }

    public function registrarProducto(Request $request)
    {
        $resultado = $this->bss_revisionproductosrecibidos->registrarProducto($request);

        return response()->json(
            $resultado, 
            $resultado['status'] 
        );
    }
}