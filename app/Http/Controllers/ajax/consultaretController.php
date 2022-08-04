<?php

namespace App\Http\Controllers\ajax;

use App\Http\Controllers\Controller;
use App\Models\orcamentodados;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class consultaretController extends Controller
{
    public function consultaret(Request $request){

        $nome = $request->name;
        $retResponse = DB::connection('odbc-ret')->table('RET051')
        ->where("PRODNome",'LIKE',"%$nome%")
        ->get();

        return response()->json($retResponse);
    }

    public function getInformationOrder(Request $request){

        $retResponse = json_encode(DB::connection('odbc-ret')->table('RET081')
        ->join('RET028', 'RET028.CLICod', '=', 'RET081.CLICod')
        ->where("SATCHAVE",$request->code)
        ->get());

        return response()->json(['dados' => $retResponse],200);
    }

    public function storeNewOrcamento(Request $request){
        if (!orcamentodados::VerifyNewOrder($request->ORCAMENTO) > 0) {
            //echo "CADASTRADO COM SUCESSO!";
            try {
                $newOrder = new orcamentodados();
                $newOrder->ORCNUM = $request->ORCAMENTO;
                $newOrder->data = $request->DATA;
                $newOrder->sat_chave = $request->SAT_CHAVE;
                $newOrder->vendedor = $request->VENDEDOR;
                $newOrder->terminal = $request->PDV;
                $newOrder->save();
                // ENVIA PARA A FILA O ORÇAMENTO
                \App\Jobs\sendOrcamentoViaApi::dispatch($request->ORCAMENTO);
                return response()->json(['response' => 'Cadastrado com sucesso!'],201);
            } catch (\Exception $e) {
                //echo "Erro ao gerar o pedido Orçamento: " . $value['ORCAMENTO'];
            }
        }else{
            return response()->json(['response' => 'Cupom Já Cadastrado!'],200);
        }
    }
}

