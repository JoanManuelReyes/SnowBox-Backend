<?php

namespace App\Services;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\EquipoLogistica;

class ENT_EquipoLogistica {

    public function listarEquipoLogistica()
    {    
        $usaurios = EquipoLogistica::all(); 

        $usauriosActivos = $usaurios->filter(function ($usaurio) {
            return $usaurio->estado == 1;
        })->values();

        return  $usauriosActivos;
    }

    public function CrearUsuario(Request $request)
    {
        $validacion = Validator::make($request->all(), [
            'id' => 'required|unique:equipologistica,id',
            'nombre' => 'required|unique:equipologistica,nombre_completo',
            'dni' => 'required|unique:equipologistica,dni|digits:8',
            'contrasenia' => 'required|string|max:8',
            'telefono' => 'required|digits:9',
        ]);
        
        if ($validacion->fails()) {
            return [
                'status' => 400,
                'message' => 'Error en validar',
                'errors' => $validacion->errors(),
            ];
        }

        $contraseniaCifrada = hash('sha256', $request->contrasenia);
        $request->merge(['contrasenia' => $contraseniaCifrada]);


        $usuario = EquipoLogistica::create([
            'nombre_completo' => $request->nombre,
            'dni' => $request->dni,
            'contrasenia' => $request->contrasenia,
            'telefono' => $request->telefono,
            'estado' => '1',
        ]);

        if (!$usuario) {
            return [
                'status' => 500,
                'message' => 'Error al crear el producto',
            ];
        }

        return [
            'status' => 200,
            'message' => 'Usuario creado correctamente',
        ];
    }

    public function ModificarUsuario(Request $request,$id)
    {
        $validacion = Validator::make($request->all(), [
            'id' => 'required|exists:equipologistica,id',
            'nombre' => 'required',
            'dni' => 'required|digits:8',
            'contrasenia' => 'required|string|max:8',
            'telefono' => 'required|digits:9',
        ]);
        
        if ($validacion->fails()) {
            return [
                'status' => 400,
                'message' => 'Error en validar',
                'errors' => $validacion->errors(),
            ];
        }

        $contraseniaCifrada = hash('sha256', $request->contrasenia);
        $request->merge(['contrasenia' => $contraseniaCifrada]);

        $usuario = EquipoLogistica::find($id);

        if (!$usuario) {
            return [
                'status' => 404,
                'message' => 'Error al encontrar al usuario',
            ];
        }

        $usuario->nombre_completo = $request->nombre;
        $usuario->dni = $request->dni;
        $usuario->contrasenia = $request->contrasenia;
        $usuario->telefono= $request->telefono;
        $usuario->save();
        
        return [
            'status' => 200,
            'message' => 'Usuario modificado correctamente',
        ];
    }

    public function EliminarUsuario($id)
    {
        $usuario = EquipoLogistica::find($id);

        if (!$usuario) {
            return [
                'status' => 404,
                'message' => 'Error al encontrar al usuario',
            ];
        }

        $usuario->estado = '0';
        $usuario->save();
        
        return [
            'status' => 200,
            'message' => 'Usuario eliminado correctamente',
        ];
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