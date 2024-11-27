<?php

namespace App\Services;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\Producto;
use App\Models\Registro;
use App\Models\ProductoBuilder;
use Illuminate\Support\Facades\DB;

class ENT_Producto {
    public function ListarProductosInv($parametro) {
        $operador = $parametro === 'Restock' ? '<' : '>=';

        $entradas = DB::table('producto as p')
        ->join('proveedor as prov', 'prov.id', '=', 'p.proveedor_id')
        ->join('registro as r', 'p.id', '=', 'r.producto_id')
        ->select('p.id', 'p.nombre', 'p.descripcion', 'p.stock', 'p.proveedor_id', 'prov.nombre as proveedor_nombre', 'r.cantidad')
        ->where('p.stock', '$operador', 5)
        ->where('r.tipo', 'Entrada')
        ->orderBy('p.id')
        ->get();

        // Consulta de salidas
        $salidas = DB::table('producto as p')
            ->join('proveedor as prov', 'prov.id', '=', 'p.proveedor_id')
            ->join('registro as r', 'p.id', '=', 'r.producto_id')
            ->select('p.id', 'p.nombre', 'p.descripcion', 'p.stock', 'p.proveedor_id', 'prov.nombre as proveedor_nombre', 'r.cantidad')
            ->where('p.stock', '$operador', 5)
            ->where('r.tipo', 'Salida')
            ->orderBy('p.id')
            ->get();

        // Consulta de devoluciones
        $devoluciones = DB::table('producto as p')
            ->leftJoin('proveedor as prov', 'prov.id', '=', 'p.proveedor_id')
            ->leftJoin('solicitud as s', function ($join) {
                $join->on('p.id', '=', 's.producto_id')
                    ->where('s.tipo', '=', 'Devolución');
            })
            ->select('p.id', 'p.nombre', 'p.descripcion', 'p.stock', 'p.proveedor_id', 'prov.nombre as proveedor_nombre', DB::raw('COALESCE(s.cantidad, 0) as cantidad'))
            ->where('p.stock', '$operador', 5)
            ->orderBy('p.id')
            ->get();

        $productoClass = new Producto();

        $entradasProcesadas = $productoClass->calcularEntradas($entradas);
        $salidasProcesadas = $productoClass->calcularSalidas($salidas);
        $devolucionesProcesadas = $productoClass->calcularDevoluciones($devoluciones);

        // Combinar todos los resultados
        $productos = [];
        foreach ($entradasProcesadas as $entrada) {
            $productos[$entrada->id] = $entrada;
        }

        foreach ($salidasProcesadas as $salida) {
            if (isset($productos[$salida->id])) {
                $productos[$salida->id]->salidas = $salida->salidas;
            } else {
                $productos[$salida->id] = $salida;
            }
        }

        foreach ($devolucionesProcesadas as $devolucion) {
            if (isset($productos[$devolucion->id])) {
                $productos[$devolucion->id]->devoluciones = $devolucion->devoluciones;
            } else {
                $productos[$devolucion->id] = $devolucion;
            }
        }

        // Completar con ceros los campos faltantes
        foreach ($productos as &$producto) {
            $producto->entradas = $producto->entradas ?? 0;
            $producto->salidas = $producto->salidas ?? 0;
            $producto->devoluciones = $producto->devoluciones ?? 0;
        }

        return array_values($productos); // Retornar un arreglo final




        /*$resultados = Producto::select(
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

        return $productos;*/
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