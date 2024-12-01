<?php

namespace App\Services;

use App\Models\Producto;
use App\Models\Solicitud;
use App\Http\Controllers\Api\ENT_CompraController;
use App\Http\Controllers\Api\ENT_ProductoController;
use App\Models\Compra;

class BSS_SeguimientoCompras {

    public function ListarCompras()
    {   
        $compras = app(ENT_CompraController::class)->listarTodosCompras();
        $productos = app(ENT_ProductoController::class)->listarTodosProductos()->toArray();

        $productosPorCompras = array_column($productos, 'nombre', 'id');

        $resultado = array_map(function ($compras) use ($productosPorCompras) {
            return [
                'id' => $compras['id'],
                'usuario_id' => $compras['usuario_id'],
                'producto_id' => $compras['producto_id'],
                'producto_nombre' => $productosPorCompras[$compras['producto_id']] ?? 0,
                'tipo' => $compras['tipo'],
                'descripcion' => $compras['descripcion'],
                'cantidad' => $compras['cantidad'],
                'fecha' => $compras['fecha'],
                'estado' => $compras['estado'],
            ];
        }, $compras);

        return $resultado;
    }

    public function ListarSolicitudes()
    {   
        $solicitudes = Solicitud::all()->toArray();
        $productos = app(ENT_ProductoController::class)->listarTodosProductos()->toArray();

        $productosPorSolicitudes = array_column($productos, 'nombre', 'id');

        $resultado = array_map(function ($solicitudes) use ($productosPorSolicitudes) {
            return [
                'id' => $solicitudes['id'],
                'usuario_id' => $solicitudes['usuario_id'],
                'producto_id' => $solicitudes['producto_id'],
                'producto_nombre' => $productosPorSolicitudes[$solicitudes['producto_id']] ?? 0,
                'tipo' => $solicitudes['tipo'],
                'descripcion' => $solicitudes['descripcion'],
                'cantidad' => $solicitudes['cantidad'],
                'fecha' => $solicitudes['fecha'],
                'estado' => $solicitudes['estado'],
            ];
        }, $solicitudes);

        return $resultado;
    }
}