<?php

namespace App\Http\Controllers\Order;

use App\Http\Controllers\Controller;
use App\Models\produtividade;
use App\Models\vendedor;
use DateTime;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class OrderConflictController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // RETORNA OS DADOS DO BANCO
        $this->ConflitOrder();
        $vendedores = vendedor::getAllVendedor();
        $pedidos = produtividade::getAllOrders();
        $totalPedidos = produtividade::getProdutividadeDaily();

        return view('view.conflit', [
            'vendedores' => $vendedores,
            'dados' => $pedidos,
            'total' => $totalPedidos
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }


    public function ConflitOrder()
    {
        try {
            $date = new DateTime();

            $orders = DB::connection('odbc-ret')->table('RET305')
                ->join('RET028', 'RET028.CLICod', '=', 'RET305.CLICOD')
                ->join('RET501', 'RET028.CIDCod', '=', 'RET501.CIDCod')
                ->select('ORCNUM', 'ORCDATA', "CLINome","ORCBAIXA","RET305.VENDCOD","ORCHR")
                ->where("ORCDATA", $date->format('Y-m-d'))
                ->distinct()
                ->get();

            $i = 0;
            $dados = [];

            try {
                $vendedoras = [10,17,31,29];
                foreach ($orders as $order) {
                    if(!$order['ORCBAIXA'] && in_array($order['VENDCOD'],$vendedoras)){
                        if(!produtividade::VerifyNewOrcamento($order['ORCNUM']) > 0){
                            $newOrcamento = new produtividade();
                            $newOrcamento->orcamento = $order['ORCNUM'];
                            $newOrcamento->dataorcamento = $order['ORCDATA'];
                            $newOrcamento->orcamentohora = $order['ORCHR'];
                            $newOrcamento->cliente = $order['CLINome'];
                            $newOrcamento->Nvendedor = $order['VENDCOD'];
                            $newOrcamento->save();
                        }
                    }
                }
            } catch (\Throwable $th) {
                $dados['Error'] = "Error Servidor Desconectado!";
            }
        } catch (\Exception $th) {
        }

    }

    public function Vendas($ORCAMENTO)
    {
        $orders = DB::connection('odbc-ret')->table('RET081')
            ->join('RET028', 'RET028.CLICod', '=', 'RET081.CLICod')
            ->join('RET501', 'RET028.CIDCod', '=', 'RET501.CIDCod')
            ->select('SAICupom', 'SAIData', "SAIHORA", "CLINome", "SATCHAVE", "ORCNUM", "RET081.VENDCOD")
            ->where('ORCNUM', '=', $ORCAMENTO)
            ->distinct()
            ->get();

        return $orders;
    }
}
