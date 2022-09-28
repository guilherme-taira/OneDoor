<?php

use App\Events\channelPublico;
use App\Http\Controllers\ajax\ChangeStatusOrderController;
use App\Http\Controllers\ajax\consultaretController;
use App\Http\Controllers\ajax\GetallOrderByClientId;
use App\Http\Controllers\Ajax\SendOrderByColaborador;
use App\Http\Controllers\Motorista\MotoristaController;
use App\Http\Controllers\Order\OrderAllDataController;
use App\Http\Controllers\Order\OrderConflictController;
use App\Http\Controllers\Order\OrderController;
use App\Http\Controllers\Rotas\RotaController;
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
Route::get('/reportFinishedOrder',[OrderAllDataController::class,'getDataForm'])->name('formFinishedOrder');
Route::get('/baixaPedidos',[OrderController::class,'getWaitingOrder'])->name('getWaitingOrder');
Route::get('/allRotas',[OrderController::class,'allRotas'])->name('allRotas');
Route::get('/generateReportMotorista',[MotoristaController::class,'generateReportMotorista'])->name('generateReportMotorista');
// ROTAS POST
Route::get('/baixarPedidosRota/{id}',[OrderController::class,'BaixaRemessa'])->name('baixarPedidosRota');
Route::put('/UpdatePaymentForm',[OrderController::class,'UpdatePaymentForm'])->name('updatepaymentform');
Route::get('/storeNewOrcamento',[consultaretController::class,'storeNewOrcamento'])->name('storeNewOrcamento');
// ROTAS AJAX
Route::get('/getAllDataOrderClientById',[GetallOrderByClientId::class,'getAllDataOrderClientById'])->name('getAllDataOrderClientById');
Route::post('/ChangeStatusOrder',[ChangeStatusOrderController::class,'ChangeStatus'])->name('ChangeStatus');
Route::get('/consultaret',[consultaretController::class,'consultaret'])->name('consultaret');
Route::post('/SendOrderByColaborador',[SendOrderByColaborador::class,'StoreProdutidade'])->name('StoreProdutidade');
// ROTAS DE SESSAO
Route::get('/setSessionRoute',[RotaController::class,'setSessionRoute'])->name('setSessionRoute');
Route::get('/DeleteOrderSessionRoute/{id}',[RotaController::class,'DeleteOrderSessionRoute'])->name('deleteSessionRoute');
Route::get('/StoreRota',[RotaController::class,'StoreRota'])->name('StoreRota');
// ROTAS RESOURCE
Route::resource('/orders','App\Http\Controllers\Order\OrderController')->names('orders')->parameters(['orders'=> 'id']);
Route::resource('/conflit','App\Http\Controllers\Order\OrderConflictController')->names('conflitador')->parameters(['conflit'=> 'id']);
Route::resource('/vendedor','App\Http\Controllers\Vendedor\VendedorController')->names('vendedor')->parameters(['vendedor' => 'id']);
Route::resource('/rotas','App\Http\Controllers\Rotas\RotaController')->names('rotas')->parameters(['rotas' => 'id']);
Route::resource('/motorista','App\Http\Controllers\Motorista\MotoristaController')->names('motorista')->parameters(['motorista' => 'id']);
Route::get('broadcast/{msg}', function($msg){
    broadcast(new channelPublico($msg));
});
