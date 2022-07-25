<?php

namespace App\Http\Controllers\Order;

use App\Http\Controllers\Controller;
use App\Models\orders;
use Illuminate\Http\Request;

class GenerateNewOrderController extends Controller
{
    public function NewOrder()
    {
        // BUSCA DADOS DO BANCO
        $orders = orders::getAllDataProcess();
        foreach ($orders as $order) {
            $CreateController = new CreateController($order->ORCNUM, $order->value, $order->value, $order->name, $order->documento, $order->telefone, $order->email, $order->endereco, $order->cep, $order->complemento, $order->numero, $order->bairro, $order->cidade, $order->UF, $order->updated_at);
            $CreateController->resource();
            
        }
    }
}
