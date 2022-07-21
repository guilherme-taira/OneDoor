<?php

use App\Events\channelPublico;
use App\Http\Controllers\Order\OrderController;
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

Route::get('/', [ViewController::class,'index'])->name('home');
Route::get('/gravapedidos', [ViewController::class,'gravapedidos'])->name('gravapedidos');
//Route::get('/orders', [ViewController::class,'orders'])->name('orders');
Route::get('/ordersFail', [ViewController::class,'ordersFail'])->name('ordersFail');
Route::get('/sendPostOrders', [ViewController::class,'index'])->name('SendDataforOneDoor');

Route::resource('/orders','App\Http\Controllers\Order\OrderController')->names('orders')->parameters(['orders'=> 'id']);

Route::get('broadcast/{msg}', function($msg){
    broadcast(new channelPublico($msg));
});
