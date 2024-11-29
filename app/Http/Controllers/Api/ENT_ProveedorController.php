<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Services\ENT_Proveedor;

class ENT_ProveedorController extends Controller
{

    private ENT_Proveedor $ent_proveedor;

    public function __construct(ENT_Proveedor $ent_proveedor)
    {
        $this->ent_proveedor = $ent_proveedor;
    }

    public function listarTodosProeveedores()
    {
        return $this->ent_proveedor->listarProveedores();
    }    

}