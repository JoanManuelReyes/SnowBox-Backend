<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\ENT_ProductoController;
use App\Http\Controllers\Api\ENT_DevolucionController;
use App\Http\Controllers\Api\ENT_EquipoLogisticaController;
use App\Http\Controllers\Api\ENT_ProveedorController;
use App\Http\Controllers\Api\ENT_CompraController;
use App\Http\Controllers\Api\BSS_RevisionProductosRecibidosController;
use App\Http\Controllers\Api\BSS_ModificacionDatosProductosController;
use App\Http\Controllers\Api\BSS_SeguimientoComprasController;
use App\Http\Controllers\Api\BSS_VerificacionInventarioController;
use App\Http\Controllers\Api\BSS_GenerarCompraProductoController;
use App\Http\Controllers\Api\BSS_GenerarDevolucionController;

Route::get('/proveedor/listarTodos', [ENT_ProveedorController::class, 'listarTodosProeveedores']);

Route::get('/producto/solicitarproducto/{id}', [ENT_ProductoController::class, 'solicitarDatosProducto']);

Route::get('/producto/listarTodos', [ENT_ProductoController::class, 'listarTodosProductos']);

Route::get('/producto/datosTablaInventario', [BSS_VerificacionInventarioController::class, 'listarTabla']);
Route::get('/producto/datosTablaRestock', [BSS_VerificacionInventarioController::class, 'listarTablaRestock']);

Route::post('/producto/registrarProducto', [BSS_RevisionProductosRecibidosController::class, 'registrarProducto']);

Route::put('/producto/modificarProducto/{id}', [BSS_ModificacionDatosProductosController::class, 'modificarProducto']);



Route::get('/devolucion/listarTodos', [ENT_DevolucionController::class, 'listarTodosDevoluciones']);
Route::get('/compra/listarTodos', [ENT_CompraController::class, 'listarTodosCompras']);



Route::post('/equipologistica/login', [ENT_EquipoLogisticaController::class, 'login']);



Route::get('/solicitud/listarSolicitudesModulo', [BSS_SeguimientoComprasController::class, 'listarTabla']);

Route::get('/compra/listarCompras', [BSS_SeguimientoComprasController::class, 'listarCompras']);

Route::post('/compra/generar', [BSS_GenerarCompraProductoController::class, 'registrarCompra']);
Route::post('/devolucion/generar', [BSS_GenerarDevolucionController::class, 'registrarDevolucion']);