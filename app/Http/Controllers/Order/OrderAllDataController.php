<?php

namespace App\Http\Controllers\Order;

use App\Http\Controllers\Controller;
use App\Models\entregador;
use App\Models\orders;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;

class OrderAllDataController extends Controller
{
    public function listallOrder()
    {
        // $dados = new OrderGetDataController('631b282f53aa27609aa2fe58','77777');
        // $dados->resource();
        // TODOS OS ENTREGADORES
        $entregadores = entregador::all();
        return view('view.ordersFinished',[
            'entregadores' => $entregadores
        ]);
    }

    public function getDataForm(Request $request)
    {

        $orders = orders::listAllOrderFinished($request->datainicial, $request->datafinal, $request->caixa, $request->status);
        // ARRAY COM DADOS DOS PEDIDOS
        $viewData = [];
        $viewData['datainicial'] = $request->datainicial;
        $viewData['datafinal'] = $request->datafinal;
        $viewData['caixa'] = $request->caixa;
        $viewData['vendas'] = $orders;

        switch ($request->status) {
            case '1':
                $viewData['status'] = "FINALIZADOS";
                break;
            case '2':
                $viewData['status'] = "EM ABERTO";
                break;
            case '3':
                $viewData['status'] = "CANCELADOS";
                break;
            default:
                $viewData['status'] = "TODOS";
                break;
        }

        // VARIAVEIS TOTAIS
        $viewData['dinheiroTotal'] = 0;
        $viewData['pixTotal'] = 0;
        $viewData['cartaoTotal'] = 0;
        $viewData['boletoTotal'] = 0;
        $viewData['outros'] = 0;
        // TRAZ O TOTAL DE TODAS FORMAS DE PAGAMENTO
        $paymentoForms = orders::getTotalPaymentForms($request->datainicial, $request->datafinal, $request->caixa, $request->status);
        foreach ($paymentoForms as $payment) {

            switch ($payment->formaPagamento) {
                case 'Dinheiro':
                    $viewData['dinheiroTotal'] += $payment->valorPago;
                    break;
                case 'Cartão':
                    $viewData['cartaoTotal'] += $payment->valorPago;
                    break;
                case 'Boleto':
                    $viewData['boletoTotal'] += $payment->valorPago;
                    break;
                case 'Pix':
                    $viewData['pixTotal'] += $payment->valorPago;
                    break;
                default:
                    $viewData['outros'] += $payment->valorPago;
                    break;
            }
        }

        $bruto = 0;
        $liquido = 0;
        $pedidos = 0;

        foreach ($viewData['vendas'] as $value) {
            orders::getCupomSaida($value->ORCNUM);
            $valor = orders::getValueRET092(substr($value->cupomFiscal, -5, 6), $value->codcli);
            try {
                //echo $value->ORCNUM . " - > " . orders::VerificaCampoCupom($value->ORCNUM) . " -> " . $valor[0]['RECVLR'] . "->" . $value->formaPagamento . "<br>";
                if (orders::VerificaCampoCupom($value->ORCNUM)) {
                    if (!empty($valor[0]['RECVLR'])) {
                        orders::where('ORCNUM', $value->ORCNUM)->update(['valorPago' => $valor[0]['RECVLR']]);
                    }
                }
            } catch (\Exception $e) {
                //echo $e->getMessage();
            }
            $bruto += $value->value;
            $liquido += $value->valorPago;
            $pedidos++;
        }

            // VALOR BRUTO E LIQUIDO
            $viewData['bruto'] = $bruto;
            $viewData['liquido'] = $liquido;
            $viewData['pedidos'] = $pedidos;
            //GERA O PDF COM OS DADOS DOS PEDIDOS
            $pdf = App::make('dompdf.wrapper');
            $pdf->setPaper('A3','landscape');
            $pdf->loadView('view.produtividade.relatorioVendas',[
                'viewData' => $viewData,
            ]);

           return $pdf->stream();
    }
}
