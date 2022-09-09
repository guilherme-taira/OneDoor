<?php

use App\Events\channelPublico;
use App\Http\Controllers\ajax\consultaretController;
use App\Http\Controllers\Ajax\SendOrderByColaborador;
use App\Http\Controllers\Order\OrderAllDataController;
use App\Http\Controllers\Order\OrderConflictController;
use App\Http\Controllers\Order\OrderController;
use App\Http\Controllers\Vendedor\VendedorController;
use App\Http\Controllers\ViewController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

// ROUTE GET
Route::get('/', [ViewController::class,'index'])->name('home');
Route::get('/gravapedidos', [ViewController::class,'gravapedidos'])->name('gravapedidos');
Route::get('/consulta', [ViewController::class,'consulta'])->name('consulta');
Route::get('/ordersFail', [ViewController::class,'ordersFail'])->name('ordersFail');
Route::get('/sendPostOrders', [ViewController::class,'index'])->name('SendDataforOneDoor');
Route::get('/getInformationOrder',[consultaretController::class,'getInformationOrder'])->name('getInformationOrder');
Route::get('/produtividade',[OrderController::class,'getProdutividade'])->name('getProdutividade');
Route::get('/reportprodutividade',[OrderController::class,'reportProdutividade'])->name('reportProdutividade');
Route::get('/generateprodutividadereport',[OrderController::class,'generateprodutividadereport'])->name('generateprodutividadereport');
Route::get('/etiqueta',[OrderController::class,'getEtiquetas'])->name('getetiqueta');
Route::get('/listallOrderFinished',[OrderAllDataController::class,'listallOrder'])->name('listaPedidosFinalizados');
// ROTAS POST
Route::get('/storeNewOrcamento',[consultaretController::class,'storeNewOrcamento'])->name('storeNewOrcamento');
// ROTAS AJAX
Route::get('/consultaret',[consultaretController::class,'consultaret'])->name('consultaret');
Route::post('/SendOrderByColaborador',[SendOrderByColaborador::class,'StoreProdutidade'])->name('StoreProdutidade');
// ROTAS RESOURCE
Route::resource('/orders','App\Http\Controllers\Order\OrderController')->names('orders')->parameters(['orders'=> 'id']);
Route::resource('/conflit','App\Http\Controllers\Order\OrderConflictController')->names('conflitador')->parameters(['conflit'=> 'id']);
Route::resource('/vendedor','App\Http\Controllers\Vendedor\VendedorController')->names('vendedor')->parameters(['vendedor' => 'id']);

Route::get('broadcast/{msg}', function($msg){
    broadcast(new channelPublico($msg));
});
