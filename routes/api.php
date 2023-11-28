<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ClienteController;
use App\Http\Controllers\ProductoController;
use App\Http\Controllers\ProveedorController;
use App\Http\Controllers\CategoriaController;



/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::post('/cliente/registrar', [ClienteController::class, 'store']);
Route::put('/cliente/{id}', [ClienteController::class, 'update']);
Route::delete('/cliente/{id}', [ClienteController::class, 'destroy']);
Route::get('/cliente', [ClienteController::class, 'index']);
Route::get('/cliente/{id}', [ClienteController::class, 'show']);

Route::post('/producto/registrar', [ProductoController::class, 'store']);
Route::put('/producto/{id}', [ProductoController::class, 'update']);
Route::delete('/producto/{id}', [ProductoController::class, 'destroy']);
Route::get('/producto', [ProductoController::class, 'index']);
Route::get('/producto/{id}', [ProductoController::class, 'show']);

Route::post('/proveedor/registrar', [ProveedorController::class, 'store']);
Route::put('/proveedor/{id}', [ProveedorController::class, 'update']);
Route::delete('/proveedor/{id}', [ProveedorController::class, 'destroy']);
Route::get('/proveedor', [ProveedorController::class, 'index']);
Route::get('/proveedor/{id}', [ProveedorController::class, 'show']);

Route::post('/categoria/registrar', [CategoriaController::class, 'store']);
Route::put('/categoria/{id}', [CategoriaController::class, 'update']);
Route::delete('/categoria/{id}', [CategoriaController::class, 'destroy']);
Route::get('/categoria', [CategoriaController::class, 'index']);
Route::get('/categoria/{id}', [CategoriaController::class, 'show']);


