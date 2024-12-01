<?php

namespace App\Services;

use App\Models\Producto;
use App\Models\Registro;
use App\Http\Controllers\Api\ENT_DevolucionController;
use App\Http\Controllers\Api\ENT_ProductoController;
use App\Http\Controllers\Api\ENT_ProveedorController;

class BSS_VerificacionInventario {

    public function ListarProductosInv($parametro) {
        $producto = app(ENT_ProductoController::class)->listarTodosProductos()->toArray();
        $registro = Registro::all()->toArray();
        $devolucion = app(ENT_DevolucionController::class)->listarTodosDevoluciones();
        $proveedor = app(ENT_ProveedorController::class)->listarTodosProeveedores()->toArray();

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
}