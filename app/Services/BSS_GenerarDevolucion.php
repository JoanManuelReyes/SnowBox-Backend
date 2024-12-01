<?php

namespace App\Services;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Http\Controllers\Api\ENT_ProductoController;
use App\Http\Controllers\Api\ENT_ProveedorController;
use App\Http\Controllers\Api\ENT_DevolucionController;
use App\Http\Controllers\Api\UTL_CorreoController;

class BSS_GenerarDevolucion {

    public function RegistrarDevolucion(Request $request) {
        $validacion = Validator::make($request->all(), [
            'id_usuario' => 'required|exists:equipologistica,id',
            'id_producto' => 'required|exists:producto,id',
            'cantidad' => 'required|numeric|min:1',
            'descripcion' => 'required',
        ]);

        if ($validacion->fails()) {
            return [
                'status' => 400,
                'message' => 'Error en validar',
                'errors' => $validacion->errors(),
            ];
        }

        $producto = app(ENT_ProductoController::class)->solicitarDatosProducto($request->id_producto);

        if (!$producto) {
            return [
                'status' => 404,
                'message' => 'Producto no encontrado',
            ];
        }

        $devolucion= app(ENT_DevolucionController::class)->crearDevolucion($request);

        if (!$devolucion) {
            return [
                'status' => 500,
                'message' => 'Error al crear la devolucion',
            ];
        }

        $producto->stock = $producto->stock-$request->cantidad;
        $producto->save();

        $proveedor = app(ENT_ProveedorController::class)->solicitarDatosProveedor($producto->proveedor_id);

        if (!$proveedor) {
            return [
                'status' => 404,
                'message' => 'Proveedor no encontrado para este producto',
            ];
        }

        $correo = app(UTL_CorreoController::class)->enviarCorreo()->send([
            'from' => 'Acme <onboarding@resend.dev>',
            'to' => [$proveedor->correo],
            'subject' => 'Orden de devolución - '.$devolucion->id,
            'html' => '
                    <html>
                        <head>
                            <title>Orden de Devolución</title>
                        </head>
                        <body>
                            <h1>¡Saludos, ' . $proveedor->nombre . '!</h1>
                            <p>Este es un correo para informarle la devolucion del producto '. $producto->nombre .'</p>
                            <p>Cantidad: '.$request->cantidad.'</p>
                            <p>Descripción: '.$request->descripcion.'</p>
                            <p>Gracias por trabajar con nosotros.</p>
                        </body>
                    </html>',
        ]);

        if (!$correo) {
            return [
                'status' => 500,
                'message' => 'Error al enviar el correo.',
            ];
        }
        
        return [
            'status' => 200,
            'message' => 'Producto registrado correctamente ',
        ];

    }
}