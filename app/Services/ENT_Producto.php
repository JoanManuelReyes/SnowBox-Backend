<?php

namespace App\Services;

use App\Models\Producto;
use Illuminate\Http\Request;
use App\Models\Registro;
use App\Http\Controllers\Api\ENT_DevolucionController;

class ENT_Producto {

    public function listarProductos()
    {   
        $producto = Producto::all();
        return $producto;
    }

    public function solicitarDatosProducto($id)
    {   
        return Producto::find($id);
    }

    public function crearProducto(Request $request){
        return Producto::create([
            'nombre' => $request->nombre,
            'descripcion' => $request->descripcion,
            'stock' => $request->entradas,
            'proveedor_id' => $request->proveedor,
        ]);
    }

    public function modificarDatosProducto(Request $request, $id){
        $producto = Producto::find($id);
        $producto->nombre = $request->nombre;
        $producto->descripcion = $request->descripcion;
        $producto->stock = $request->entradas-$request->salidas;
        $producto->proveedor_id= $request->proveedor;
        $producto->save();
        return [
            'status' => 200,
            'message' => 'Producto modificado correctamente desde Entidad',
        ];
    }

    public function listarRegistrosyDevoluciones(){
        $registros = Registro::all()->toArray();
        $devoluciones = app(ENT_DevolucionController::class)->listarTodosDevoluciones();
        $productos = Producto::all()->toArray();

        $resultado = []; // Array para almacenar los resultados finales

        // Recorrer cada producto
        foreach ($productos as $producto) {
            foreach ($registros as $registro) {
                if ($registro['producto_id'] === $producto['id']) {
                    $resultado[] = [
                        'id' => $registro['id'],
                        'tipo' => $registro['tipo'],
                        'nombre_producto' => $producto['nombre'],
                        'id_producto' => $producto['id'],
                        'cantidad' => $registro['cantidad'],
                        'fecha' => $registro['fecha'],
                    ];
                }
            }

            foreach ($devoluciones as $devolucion) {
                if ($devolucion['producto_id'] === $producto['id']) {
                    $resultado[] = [
                        'id' => $devolucion['id'],
                        'tipo' => $devolucion['tipo'],
                        'nombre_producto' => $producto['nombre'],
                        'id_producto' => $producto['id'],
                        'cantidad' => $devolucion['cantidad'],
                        'fecha' => $devolucion['fecha'],
                    ];
                }
            }
        }
        return $resultado;
    }
}