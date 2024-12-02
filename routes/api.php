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
use App\Http\Controllers\Api\PdfServiceController;

Route::get('/proveedor/listarTodos', [ENT_ProveedorController::class, 'listarTodosProeveedores']);
Route::get('/proveedor/datosProveedor/{id}', [ENT_ProveedorController::class, 'solicitarDatosProveedor']);
Route::post('/proveedor/registrarProveedor', [ENT_ProveedorController::class, 'crearProveedor']);
Route::put('/proveedor/modificarProveedor/{id}', [ENT_ProveedorController::class, 'modificarProveedor']);


Route::get('/producto/solicitarproducto/{id}', [ENT_ProductoController::class, 'solicitarDatosProducto']);

Route::get('/producto/listarTodos', [ENT_ProductoController::class, 'listarTodosProductos']);

Route::get('/producto/datosTablaReportes', [ENT_ProductoController::class, 'listarReportes']);

Route::get('/producto/datosTablaInventario', [BSS_VerificacionInventarioController::class, 'listarTabla']);
Route::get('/producto/datosTablaRestock', [BSS_VerificacionInventarioController::class, 'listarTablaRestock']);

Route::post('/producto/registrarProducto', [BSS_RevisionProductosRecibidosController::class, 'registrarProducto']);

Route::put('/producto/modificarProducto/{id}', [BSS_ModificacionDatosProductosController::class, 'modificarProducto']);


Route::get('/compra/listarTodos', [BSS_SeguimientoComprasController::class, 'listarCompras']);
Route::get('/compra/listarCompras', [ENT_CompraController::class, 'listarTodosCompras']);
Route::post('/compra/generar', [BSS_GenerarCompraProductoController::class, 'registrarCompra']);
Route::put('/compra/actualizarEstado/{id}', [ENT_CompraController::class, 'actualizarEstadoCompra']);


Route::get('/devolucion/listarTodos', [ENT_DevolucionController::class, 'listarTodosDevoluciones']);
Route::post('/devolucion/generar', [BSS_GenerarDevolucionController::class, 'registrarDevolucion']);
Route::put('/devolucion/actualizarEstado/{id}', [ENT_DevolucionController::class, 'actualizarEstadoDevolucion']);


Route::get('/equipologistica/listar', [ENT_EquipoLogisticaController::class, 'listarEquipoLogistica']);
Route::post('/equipologistica/crearUsuario', [ENT_EquipoLogisticaController::class, 'crearEquipoLogistica']);
Route::put('/equipologistica/modificarUsuario/{id}', [ENT_EquipoLogisticaController::class, 'modificarEquipoLogistica']);
Route::delete('/equipologistica/eliminarUsuario/{id}', [ENT_EquipoLogisticaController::class, 'eliminarEquipoLogistica']);


Route::post('/equipologistica/login', [ENT_EquipoLogisticaController::class, 'login']);


Route::get('/solicitud/listarSolicitudesModulo', [BSS_SeguimientoComprasController::class, 'listarTabla']);


Route::post('/pdf/generar', [PdfServiceController::class, 'generarPDF']);


