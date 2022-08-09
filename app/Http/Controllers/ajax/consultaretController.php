<?php

namespace App\Http\Controllers\ajax;

use App\Http\Controllers\Controller;
use App\Http\Controllers\ViewController;
use App\Models\orcamentodados;
use App\Models\orders;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class consultaretController extends ViewController
{
    public function consultaret(Request $request){

        $nome = $request->name;
        $retResponse = DB::connection('odbc-ret')->table('RET051')
        ->where("PRODNome",'LIKE',"%$nome%")
        ->get();

        return response()->json($retResponse);
    }

    public function getInformationOrder(Request $request){

        try {
            $retResponse = DB::connection('odbc-ret')->table('RET081')
            // ->join('RET028', 'RET028.CLICod', '=', 'RET081.CLICod')
            ->where("SATCHAVE",'=',$request->code)
            ->get();

            return response()->json(['dados' => json_encode($retResponse)]);
        } catch (\Exception $e) {
            return response()->json(['dados' => $e->getMessage()]);
        }



        // return response()->json(['dados' => $retResponse],200);
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
                $this->GravaBancoDadosManual($request->ORCAMENTO);
                return response()->json(['response' => 'Cadastrado com Sucesso!']);
            } catch (\Exception $e) {
                //echo "Erro ao gerar o pedido Orçamento: " . $value['ORCAMENTO'];
            }
        }else{
            return response()->json(['response' => 'Cupom Já Cadastrado!'],200);
        }
    }

    public function GravaBancoDadosManual($ORCAMENTO){

        $pesquisas = DB::connection('odbc-ret')->table('RET081')
            ->join('RET028', 'RET028.CLICod', '=', 'RET081.CLICod')
            ->join('RET501', 'RET028.CIDCod', '=', 'RET501.CIDCod')
            ->select("CLINome", "CLICPF", "CLIRG", "CLICNPJ", "CLIEmail", "CLIEnd", "CLICep", "CLIBairro", "CLINUMERO", "CIDNome", "CIDUF", "CLIRef", "SAICupom", "SAITOTAL", "SAIQtde", "SAIDESCONTO", "SAIHORA", "CLIFone1")
            ->where('SAICupom', '=', $ORCAMENTO)
            ->get();

        foreach ($pesquisas as $pesquisa) {

            $ORCAMENTO = $pesquisa['SAICupom'];

            //VERIFICA SE JÀ FOI CADASTRADO O ORÇAMENTO
            if (!orders::VerifyNewOrder($ORCAMENTO) > 0) {
                if (isset($ORCAMENTO)) {
                    // FUNCTION USER
                    try {
                        $NewUser = new User();
                        $NewUser->name = utf8_encode($pesquisa['CLINome']);
                        $NewUser->email = isset($pesquisa['CLIEmail']) ? $pesquisa['CLIEmail'] : 'contato@embaleme.com';
                        $NewUser->documento = '' != ($this->DocumentFilter($pesquisa)) ? $this->DocumentFilter($pesquisa) : '11111111111';
                        $NewUser->telefone = $this->countNumber($this->TelefoneFilter($pesquisa));
                        $NewUser->endereco = utf8_encode($pesquisa['CLIEnd']);
                        $NewUser->cep = $pesquisa['CLICep'];
                        $NewUser->bairro = utf8_encode($pesquisa['CLIBairro']);
                        $NewUser->complemento = utf8_encode($pesquisa['CLIRef']);
                        $NewUser->numero = $this->TrataNumero($pesquisa['CLINUMERO']);
                        $NewUser->cidade = $pesquisa['CIDNome'];
                        $NewUser->UF = $pesquisa['CIDUF'];
                        $NewUser->save();
                    } catch (\Exception $e) {
                        echo $e->getMessage();
                        echo $e->getCode();
                    }

                    // FUNCTION ORDER
                    $StoreData = new orders();
                    $StoreData->value = $pesquisa['SAITOTAL'];
                    $StoreData->quantity_items = $pesquisa['SAIQtde'];
                    $StoreData->ORCNUM = isset($ORCAMENTO) ? $ORCAMENTO : uniqid();
                    $StoreData->desconto = $pesquisa['SAIDESCONTO'];
                    $StoreData->HORASAIDA = $pesquisa['SAIHORA'];
                    $StoreData->client_id = $NewUser->getID();
                    $StoreData->save();
                }
            }
       }
    }
}

