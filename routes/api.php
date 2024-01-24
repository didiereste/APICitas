<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\CitaController;
use App\Http\Controllers\ClienteController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::group([

    'middleware' => 'api',
    'prefix' => 'auth'

], function () {
    Route::post('login', [AuthController::class, 'login']);
    Route::post('register', [AuthController::class, 'register']);
    Route::post('logout',[AuthController::class, 'logout']);
    Route::post('me',  [AuthController::class, 'me']);
});


Route::middleware(['auth:api'])->group(function () {
    //rutas cliente
    Route::post('/pedircita', [CitaController::class, 'pedircita']);
    Route::get('/miscitas/{id}',[ClienteController::class, 'miscitas']);

    //rutas admin
    Route::put('/cita/cambiarestado/{id}', [AdminController::class, 'cambiarestado']);
    Route::get('/citas/lista', [AdminController::class, 'listadocitas']);
    Route::get('/usuarios/lista', [AdminController::class, 'userlistado']);
    Route::get('/usuario/perfil/{id}',[AdminController::class, 'mostraruser']);
    Route::delete('/eliminar/usuario/{id}', [AdminController::class, 'deleteuser']);
    Route::put('/actualizar/usuario/{id}', [AdminController::class, 'updateuser']); 
});




