<?php

use App\Http\Controllers\Api\GetOrcamentoController;
use App\Http\Controllers\Api\OrdersController;
use App\Http\Controllers\Api\UsersController;
use App\Http\Controllers\Order\sendOrderQueueController;
use App\Jobs\sendOrcamentoViaApi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

// Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//     return $request->user();
// });


Route::prefix('v1')->group(function(){
    // LISTAR TODOS OS PEDIDOS
    Route::get('orders',[OrdersController::class,'index']);
    // LISTAR TODOS OS USUARIOS
    Route::get('users',[UsersController::class,'index']);
    Route::get('pedido',[GetOrcamentoController::class,'index']);


    // CADASTRAR NOVO PEDIDO
    Route::post('NewOrder',[OrdersController::class,'store']);
    Route::post('pedido',[GetOrcamentoController::class,'store']);
});
