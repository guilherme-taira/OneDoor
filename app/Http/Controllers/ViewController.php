<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Auth\AuthController;
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
        // $GenerateNewOrderController = new GenerateNewOrderController();
        // $GenerateNewOrderController->NewOrder();

        $auth = new AuthController();
        print_r($auth->resource());

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

        // CAIXA 10
        $pesquisas = DB::connection('caixa10')->table('PAF06')
            ->whereBetween('DATA', [$data, $data])
            ->where('ORCAMENTO', '!=', null)
            ->distinct()
            ->select('ORCAMENTO', 'DATA', 'SAT_CHAVE', 'PDV', 'VENDEDOR')
            ->get();

        foreach ($pesquisas as $value) {
            //VERIFICA SE JÀ FOI CADASTRADO O ORÇAMENTO
            if (!orcamentodados::VerifyNewOrder($value['ORCAMENTO']) > 0) {
                //echo "CADASTRADO COM SUCESSO!";
                try {
                    $newOrder = new orcamentodados();
                    $newOrder->ORCNUM = $value['ORCAMENTO'];
                    $newOrder->data = $value['DATA'];
                    $newOrder->sat_chave = $value['SAT_CHAVE'];
                    $newOrder->vendedor = $value['VENDEDOR'];
                    $newOrder->terminal = $value['PDV'];
                    $newOrder->save();
                    // ENVIA PARA A FILA O ORÇAMENTO
                    \App\Jobs\sendOrcamentoViaApi::dispatch($value['ORCAMENTO']);
                } catch (\Exception $e) {
                    //echo "Erro ao gerar o pedido Orçamento: " . $value['ORCAMENTO'];
                }
            }
        }

        // CAIXA 11
        $pesquisas = DB::connection('caixa11')->table('PAF06')
            ->whereBetween('DATA', [$data, $data])
            ->where('ORCAMENTO', '!=', null)
            ->distinct()
            ->select('ORCAMENTO', 'DATA', 'SAT_CHAVE', 'PDV', 'VENDEDOR')
            ->get();

        foreach ($pesquisas as $value) {
            //VERIFICA SE JÀ FOI CADASTRADO O ORÇAMENTO
            if (!orcamentodados::VerifyNewOrder($value['ORCAMENTO']) > 0) {
                //echo "CADASTRADO COM SUCESSO!";
                try {
                    $newOrder = new orcamentodados();
                    $newOrder->ORCNUM = $value['ORCAMENTO'];
                    $newOrder->data = $value['DATA'];
                    $newOrder->sat_chave = $value['SAT_CHAVE'];
                    $newOrder->vendedor = $value['VENDEDOR'];
                    $newOrder->terminal = $value['PDV'];
                    $newOrder->save();
                    // ENVIA PARA A FILA O ORÇAMENTO
                    \App\Jobs\sendOrcamentoViaApi::dispatch($value['ORCAMENTO']);
                } catch (\Exception $e) {
                    //echo "Erro ao gerar o pedido Orçamento: " . $value['ORCAMENTO'];
                }
            }
        }


        $sendData = new GenerateNewOrderController();
        $sendData->NewOrder();

        // dados de orçamentos do dia
        $orcamentodados = orcamentodados::where('created_at','LIKE','%'.$data.'%')->get();

        return view('view.gravapedidos', [
            'pedidos' => $orcamentodados
        ]);
    }


    public function consulta()
    {
        return view('view.consulta');
    }
}
