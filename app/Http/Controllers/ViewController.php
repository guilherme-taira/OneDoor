<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Order\CreateController;
use App\Http\Controllers\Order\GenerateNewOrderController;
use App\Models\orcamentodados;
use App\Models\orders;
use App\Models\User;
use DateTime;
use Hamcrest\Type\IsNumeric;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ViewController extends Controller
{
    public function index()
    {
        // $CreateController = new CreateController();
        // print_r($CreateController->resource());
        $GenerateNewOrderController = new GenerateNewOrderController();
        $GenerateNewOrderController->NewOrder();
        return view('view.index');
    }

    public function ordersFail()
    {

        $orders = orders::getAllOrderFailPaginate();
        return view('view.ordersFails', [
            'orders' => $orders
        ]);
    }


    public function gravapedidos()
    {

        $today = new DateTime();
        //$today->modify('-3 day');
        $data = $today->format('Y-m-d');

        $pesquisas = DB::connection('odbc-connection-name')->table('PAF06')
            ->whereBetween('DATA', [$data, $data])
            ->where('ORCAMENTO', '!=', null)
            ->distinct()
            ->select('ORCAMENTO', 'DATA', 'SAT_CHAVE', 'PDV', 'VENDEDOR')
            ->get();

        foreach ($pesquisas as $value) {
            //VERIFICA SE JÀ FOI CADASTRADO O ORÇAMENTO
            if (!orcamentodados::VerifyNewOrder($value['ORCAMENTO']) > 0) {
                try {
                    $newOrder = new orcamentodados();
                    $newOrder->ORCNUM = $value['ORCAMENTO'];
                    $newOrder->data = $value['DATA'];
                    $newOrder->sat_chave = $value['SAT_CHAVE'];
                    $newOrder->vendedor = $value['VENDEDOR'];
                    $newOrder->terminal = $value['PDV'];
                    $newOrder->save();
                    // ENVIA PARA A FILA O ORÇAMENTO
                    \App\Jobs\sendOrcamentoViaApi::dispatch($value['ORCAMENTO'])->delay(now()->addSecond(2));
                    // ENVIA PARA PLATAFORMA
                    $orders = orders::getAllDataProcess();
                    foreach ($orders as $order) {
                        \App\Jobs\sendOrderforPlataform::dispatch($order->ORCNUM, $order->value, $order->value, $order->name, $order->documento, $order->telefone, $order->email, $order->endereco, $order->cep, $order->complemento, $order->numero, $order->bairro, $order->cidade, $order->UF, $order->updated_at)->delay(now()->addSecond(2));
                    }
                } catch (\Exception $e) {
                    //echo "Erro ao gerar o pedido Orçamento: " . $value['ORCAMENTO'];
                }
            }
        }

        return view('view.gravapedidos', [
            'pedidos' => $pesquisas
        ]);
    }

    public function storeDataDB($nome, $documento, $phoneNumber, $email, $Rua, $Cep, $Complemento, $Numero, $Cidade, $Estado, $preco)
    {
    }
}
