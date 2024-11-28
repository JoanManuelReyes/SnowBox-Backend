<?php

namespace App\Services;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\Producto;
use App\Models\Registro;
use App\Models\Builder;
use App\Models\Proveedor;
use App\Models\Solicitud;

class ENT_Producto {
    public function ListarProductosInv($parametro) {
        $producto = Producto::all()->toArray();
        $registro = Registro::all()->toArray();
        $solicitud = Solicitud::all()->toArray();
        $proveedor = Proveedor::all()->toArray();

        $productosFiltrados = array_filter($producto, function ($productos) use ($parametro) {
            if ($parametro === 'Restock') {
                return $productos['stock'] < 5;
            } elseif ($parametro === 'Normal') {
                return $productos['stock'] >= 5;
            }
        });

        $entrada = array_filter($registro, function ($entradas){
            return $entradas['tipo'] == 'Entrada';
        });

        $salida = array_filter($registro, function ($salidas){
            return $salidas['tipo'] == 'Salida';
        });

        $devolucion = array_filter($solicitud, function ($devoluciones){
            return $devoluciones['tipo'] == 'Devolución';
        });

        $productoClass = new Producto();
        
        $entradasSumadas=$productoClass->calcularEntradas($entrada);
        $salidasSumadas=$productoClass->calcularSalidas($salida);
        $devolucionesSumadas=$productoClass->calcularDevoluciones($devolucion);

        $entradasPorProducto = array_column($entradasSumadas, 'cantidad', 'producto_id');
        $salidasPorProducto = array_column($salidasSumadas, 'cantidad', 'producto_id');
        $devolucionesPorProducto = array_column($devolucionesSumadas, 'cantidad', 'producto_id');
        $proveedorPorId = array_column($proveedor, 'nombre', 'id');

        $resultado = array_map(function ($producto) use ($entradasPorProducto, $salidasPorProducto, $devolucionesPorProducto, $proveedorPorId) {
            return [
                'id' => $producto['id'],
                'nombre' => $producto['nombre'],
                'descripcion' => $producto['descripcion'],
                'stock' => $producto['stock'],
                'proveedor_id' => $producto['proveedor_id'],
                'proveedor_nombre' => $proveedorPorId[$producto['proveedor_id']] ?? 'Desconocido',
                'entradas' => $entradasPorProducto[$producto['id']] ?? 0,
                'salidas' => $salidasPorProducto[$producto['id']] ?? 0,
                'devoluciones' => $devolucionesPorProducto[$producto['id']] ?? 0,
            ];
        }, $productosFiltrados);
        return array_values($resultado); 
    }

    public function RegistrarProducto(Request $request) {
        $validacion = Validator::make($request->all(), [
            'id' => 'required|unique:producto,id',
            'nombre' => 'required|unique:producto,nombre',
            'proveedor' => 'required|exists:proveedor,id',
            'descripcion' => 'required',
            'entradas' => 'required',
        ]);

        if ($validacion->fails()) {
            return [
                'status' => 400,
                'message' => 'Error en validar',
                'errors' => $validacion->errors(),
            ];
        }

        $producto = Producto::create([
            'nombre' => $request->nombre,
            'descripcion' => $request->descripcion,
            'stock' => $request->entradas,
            'proveedor_id' => $request->proveedor,
        ]);

        if (!$producto) {
            return [
                'status' => 500,
                'message' => 'Error al crear el producto',
            ];
        }

        $registro = Registro::create([
            'fecha' => now(),
            'tipo' => 'Entrada',
            'cantidad' => $request->entradas,
            'producto_id' => $producto->id,
        ]);
    
        if (!$registro) {
            return [
                'status' => 500,
                'message' => 'Producto creado, pero falló al registrar la entrada',
            ];
        }

        return [
            'status' => 200,
            'message' => 'Producto registrado correctamente ',
        ];

    }

    public function ModificarProducto(Request $request,$id) {
        $validacion = Validator::make($request->all(), [
            'id' => 'required|exists:producto,id',
            'nombre' => 'required',
            'proveedor' => 'required|exists:proveedor,id',
            'descripcion' => 'required',
            'entradas' => 'required',
            'salidas' => 'required',
        ]);

        if ($validacion->fails()) {
            return [
                'status' => 400,
                'message' => 'Error en validar',
                'errors' => $validacion->errors(),
            ];
        }

        //sumas actuales de entradas y salidas del producto desde la base de datos
        $producto = Producto::find($id);
        if (!$producto) {
            return [
                'status' => 404,
                'message' => 'Producto no encontrado',
            ];
        }

        $producto->nombre = $request->nombre;
        $producto->descripcion = $request->descripcion;
        $producto->stock = $request->entradas-$request->salidas;
        $producto->proveedor_id= $request->proveedor;
        $producto->save();

        $registro = Registro::all()->toArray();
        
        $entrada = array_filter($registro, function ($entradas){
            return $entradas['tipo'] == 'Entrada';
        });

        $salida = array_filter($registro, function ($salidas){
            return $salidas['tipo'] == 'Salida';
        });

        $entradasActuales = $producto->calcularEntradas($entrada);
        $salidasActuales = $producto->calcularSalidas($salida);

        if($request->entradas<$salidasActuales){
            return [
                'status' => 400,
                'message' => 'Error en validar',
                'errors' => [
                    'entradas' => [
                        "El valor de las entradas no puede ser menor a las salidas.",
                    ],
                ],
            ];
        }

        if ($request->entradas < $entradasActuales) {
            return [
                'status' => 400,
                'message' => 'Error en validar',
                'errors' => [
                    'entradas' => [
                        "El valor de entradas debe ser mayor a $entradasActuales.",
                    ],
                ],
            ];
        }

        if ($request->entradas > $entradasActuales) {
            Registro::create([
                'fecha' => now(),
                'tipo' => 'Entrada',
                'cantidad' => $request->entradas-$entradasActuales,
                'producto_id' => $producto->id,
            ]);
        }

        if ($request->salidas < $salidasActuales) {
            return [
                'status' => 400,
                'message' => 'Error en validar',
                'errors' => [
                    'salidas' => [
                        "El valor de salidas debe ser mayor a $salidasActuales.",
                    ],
                ],
            ];
        }
        if ($request->salidas > $salidasActuales){
            Registro::create([
                'fecha' => now(),
                'tipo' => 'Salida',
                'cantidad' => $request->salidas-$salidasActuales,
                'producto_id' => $producto->id,
            ]);
        }
        
        return [
            'status' => 200,
            'message' => 'Producto modificado correctamente ',
        ];

    }
}

?>