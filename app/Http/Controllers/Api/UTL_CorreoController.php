<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Services\UTL_Correo;

class UTL_CorreoController extends Controller
{

    private UTL_Correo $utl_correo;

    public function __construct(UTL_Correo $utl_correo)
    {
        $this->utl_correo = $utl_correo;
    }



}
