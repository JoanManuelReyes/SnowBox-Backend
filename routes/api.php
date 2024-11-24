<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\productoController;

Route::get('/producto/datosTablaInventario', [productoController::class, 'listarTabla']);
Route::get('/producto/datosTablaRestock', [productoController::class, 'listarTablaRestock']);

Route::post('/producto/registrarProducto', [productoController::class, 'registrarProducto']);
Route::put('/producto/modificarProducto/{id}', [productoController::class, 'modificarProducto']);

