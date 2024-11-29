<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Services\ENT_EquipoLogistica;

class ENT_EquipoLogisticaController extends Controller
{

    private ENT_EquipoLogistica $ent_equipologistica;

    public function __construct(ENT_EquipoLogistica $ent_equipologistica)
    {
        $this->ent_equipologistica = $ent_equipologistica;
    }

    public function login(Request $request)
    {
        $resultado = $this->ent_equipologistica->login($request);

        return response()->json(
            $resultado, 
            $resultado['status'] 
        );
    } 


}