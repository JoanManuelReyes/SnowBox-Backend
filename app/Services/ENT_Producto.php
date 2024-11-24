<?php

namespace App\Services;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\Producto;
use App\Models\Registro;
use App\Models\ProductoBuilder;

class ENT_Producto {
    public function ListarProductosInv($parametro) {
        $operador = $parametro === 'Restock' ? '<' : '>=';

        $resultados = Producto::select(
            'producto.id',
            'producto.nombre',
            'producto.descripcion',
            'producto.stock',
            'producto.proveedor_id',
            'proveedor.nombre as proveedor_nombre'
        )
        ->join('proveedor', 'producto.proveedor_id', '=', 'proveedor.id')
        ->where('stock', $operador, 5) 
        ->orderBy('producto.id')
        ->get();

        $productos = $resultados->map(function ($producto) {
            $entradas = $producto->calcularEntradas();
            $salidas = $producto->calcularSalidas();
            $devoluciones = $producto->calcularDevoluciones();

            $builder = new ProductoBuilder();
            return $builder->setId($producto->id)
                ->setNombre($producto->nombre)
                ->setDescripcion($producto->descripcion)
                ->setStock($producto->stock)
                ->setEntradas($entradas)
                ->setSalidas($salidas)
                ->setDevoluciones($devoluciones)
                ->setProveedorId($producto->proveedor_id)
                ->build();
        });

        return $productos;
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

        $entradasActuales = $producto->calcularEntradas();
        $salidasActuales = $producto->calcularSalidas();

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