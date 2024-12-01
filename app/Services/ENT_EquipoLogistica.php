<?php

namespace App\Services;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\EquipoLogistica;

class ENT_EquipoLogistica {

    public function listarEquipoLogistica()
    {   
        $proveedores = EquipoLogistica::all();
        return $proveedores;
    }

    public function login(Request $request)
    {
        $contraseniaCifrada = hash('sha256', $request->contrasenia);
        $request->merge(['contrasenia' => $contraseniaCifrada]);

        $validacion = Validator::make($request->all(), [
            'dni' => 'required|exists:equipologistica,dni',
            'contrasenia' => 'required|exists:equipologistica,contrasenia',
        ]);

        if ($validacion->fails()) {
            return [
                'status' => 400,
                'message' => 'Error en validar',
                'errors' => $validacion->errors(),
            ];
        }

        $usuario = EquipoLogistica::where('dni', $request->dni)
                              ->where('contrasenia', $request->contrasenia)
                              ->first();
        
                              
        return [
        'status' => 200,
        'message' => $usuario->id,
        ];
    }
}