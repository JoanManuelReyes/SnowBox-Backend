<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\ENT_ProductoController;
use App\Http\Controllers\Api\ENT_DevolucionController;
use App\Http\Controllers\Api\ENT_EquipoLogisticaController;
use App\Http\Controllers\Api\ENT_CompraController;
use App\Http\Controllers\Api\BSS_RevisionProductosRecibidosController;
use App\Http\Controllers\Api\BSS_ModificacionDatosProductosController;
use App\Http\Controllers\Api\BSS_VerificacionInventarioController;


Route::get('/producto/listarTodos', [ENT_ProductoController::class, 'listarTodosProductos']);

Route::get('/producto/datosTablaInventario', [BSS_VerificacionInventarioController::class, 'listarTabla']);
Route::get('/producto/datosTablaRestock', [BSS_VerificacionInventarioController::class, 'listarTablaRestock']);

Route::post('/producto/registrarProducto', [BSS_RevisionProductosRecibidosController::class, 'registrarProducto']);

Route::put('/producto/modificarProducto/{id}', [BSS_ModificacionDatosProductosController::class, 'modificarProducto']);



Route::get('/devolucion/listarTodos', [ENT_DevolucionController::class, 'listarTodosDevoluciones']);
Route::get('/compra/listarTodos', [ENT_CompraController::class, 'listarTodosCompras']);

Route::post('/equipologistica/login', [ENT_EquipoLogisticaController::class, 'login']);
