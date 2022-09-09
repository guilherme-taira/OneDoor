<?php

namespace App\Http\Controllers\Order;

use App\Http\Controllers\Controller;
use App\Models\orders;
use Illuminate\Http\Request;

class OrderAllDataController extends Controller
{
    public function listallOrder(){
        echo "<pre>";

        $dados = new OrderGetDataController('631b282f53aa27609aa2fe58','77777');
        $dados->resource();
        // $orders = orders::listAllOrderFinished();
        // return view('view.ordersFinished',[
        //     'orders' => $orders,
        // ]);
    }

}
