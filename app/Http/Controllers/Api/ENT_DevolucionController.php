<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Services\ENT_Devolucion;

class ENT_DevolucionController extends Controller
{

    private ENT_Devolucion $ent_devolucion;

    public function __construct(ENT_Devolucion $ent_devolucion)
    {
        $this->ent_devolucion = $ent_devolucion;
    }

    public function listarTodosDevoluciones()
    {
        return $this->ent_devolucion->listarDevoluciones();
    } 

}