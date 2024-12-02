<?php

namespace App\Services;

use App\Models\Proveedor;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;

class ENT_Proveedor {

    public function listarProveedores()
    {   
        $proveedores = Proveedor::all();
        return $proveedores;
    }

    public function solicitarDatosProveedor($id)
    {   
        return Proveedor::find($id);
    }


    public function crearProveedor(Request $request)
    {   
        $validacion = Validator::make($request->all(), [
            'id' => 'required|unique:proveedor,id',
            'nombre' => 'required|unique:proveedor,nombre',
            'ruc' => 'required|digits:11|unique:proveedor,ruc',
            'telefono' => 'required|digits:9|unique:proveedor,telefono',
            'correo' => 'required|email|unique:proveedor,correo',
        ]);

        if ($validacion->fails()) {
            return [
                'status' => 400,
                'message' => 'Error en validar',
                'errors' => $validacion->errors(),
            ];
        }

        $proveedor = Proveedor::create([
            'nombre' => $request->nombre,
            'ruc' => $request->ruc,
            'telefono' => $request->telefono,
            'correo' => $request->correo,
        ]);

        if (!$proveedor) {
            return [
                'status' => 500,
                'message' => 'Error al crear el proveedor',
            ];
        }

        return [
            'status' => 200,
            'message' => 'Proveedor registrado correctamente ',
        ];
    }

    public function modificarProveedor(Request $request,$id)
    {   
        $validacion = Validator::make($request->all(), [
            'id' => 'required|exists:proveedor,id',
            'nombre' => 'required',
            'ruc' => 'required|digits:11',
            'telefono' => 'required|digits:9',
            'correo' => 'required|email',
        ]);

        if ($validacion->fails()) {
            return [
                'status' => 400,
                'message' => 'Error en validar',
                'errors' => $validacion->errors(),
            ];
        }
        
        $proveedor = Proveedor::find($id);

        if (!$proveedor) {
            return [
                'status' => 404,
                'message' => 'Proveedor no encontrado',
            ];
        }

        $proveedor->nombre = $request->nombre;
        $proveedor->ruc = $request->ruc;
        $proveedor->telefono = $request->telefono;
        $proveedor->correo = $request->correo;
        $proveedor->save();

        return [
            'status' => 200,
            'message' => 'Proveedor modificado correctamente ',
        ];
    }
}