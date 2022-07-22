<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\orders;
use App\Models\User;
use DateTime;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class GetOrcamentoController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $today = new DateTime();
        $today->modify('-1 day');
        $data = $today->format('Y-m-d');

        $pesquisas = DB::connection('odbc-connection-name')->table('PAF06')
        ->whereBetween('DATA', [$data, $data])
        ->where('ORCAMENTO','!=',null)
        ->distinct()
        ->select('ORCAMENTO','DATA','SAT_CHAVE')
        ->get();
        return response()->json($pesquisas);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $pesquisas = DB::connection('odbc-connection-name')->table('RET081')
        ->join('RET028', 'RET028.CLICod', '=', 'RET081.CLICod')
        ->join('RET501', 'RET028.CIDCod', '=', 'RET501.CIDCod')
        ->select("CLINome", "CLICPF", "CLIRG", "CLICNPJ", "CLIEmail", "CLIEnd", "CLICep", "CLIBairro", "CLINUMERO", "CIDNome", "CIDUF", "SAIQtde", "SAIVDA", "SAIDESCONTO", "CLIFone1", "CLIFone2", "CLIRef", "ORCNUM", "SAIData", "CLIBairro", "SAIHORA")
        ->where('ORCNUM','=',$request->orcamento)
        ->get();

          foreach ($pesquisas as $pesquisa) {
            $total = 0;
            $quantity_items = 0;

            $ORCAMENTO = $pesquisa['ORCNUM'];

            foreach ($pesquisas as $precos) {
                if ($ORCAMENTO == $precos['ORCNUM']) {
                    $total += $precos['SAIVDA'];
                    $quantity_items += $precos['SAIQtde'];
                }
            }

            //VERIFICA SE JÀ FOI CADASTRADO O ORÇAMENTO
            if (orders::VerifyNewOrder($ORCAMENTO) > 0) {
                return response()->json('Pedido Já Cadastrado!',404);
            } else {
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
                    $StoreData->value = $total;
                    $StoreData->quantity_items = $quantity_items;
                    $StoreData->ORCNUM = isset($ORCAMENTO) ? $ORCAMENTO : uniqid();
                    $StoreData->desconto = $pesquisa['SAIDESCONTO'];
                    $StoreData->HORASAIDA = $pesquisa['SAIHORA'];
                    $StoreData->client_id = $NewUser->getID();
                    $StoreData->save();
                }
            }
        }
            return response()->json('Cadastrado Com Sucesso!',200);
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

    public function TelefoneFilter(array $telefone)
    {
        $regex = "/ /";
        $replacement = "";

        if ($telefone['CLIFone1'] == 'null' || $telefone['CLIFone2'] == 'null' || $telefone['CLIFone1'] == '' || $telefone['CLIFone2'] == '') {
            return '5599999999999';
        } else if (strlen(preg_replace($regex, $replacement, $telefone['CLIFone1'])) > strlen(preg_replace($regex, $replacement, $telefone['CLIFone1']))) {
            $telefone = preg_replace($regex, $replacement, $telefone['CLIFone1']);
            return '55' . $telefone;
        } else {
            $telefone = preg_replace($regex, $replacement, $telefone['CLIFone2']);
            return '55' . $telefone;
        }
    }


    public function countNumber($numero){
        $regexFone = "/^55/";
        $regexEspecial = "";

        if (preg_match($regexFone, $numero) == TRUE) {
            $res = substr($numero, -13);
        } elseif (preg_match($regexEspecial, $numero) == TRUE) {
            $res = preg_replace('/[@\.\;\-\(\)\" "]+/', '', $numero);
        } else {
            $res = $numero;
        }
        return $res;
    }

    public function DocumentFilter(array $documento)
    {
        $array = [];
        $chave = "";
        array_push($array, $documento['CLIRG'], $documento['CLICPF'], $documento['CLICNPJ']);
        foreach ($array as $value) {
            if ($value > 0) {
                $chave = $value;
            }
        }
        return $chave;
    }

    public function TrataNumero($numero)
    {
        if (ctype_alpha($numero)) {
            return 0;
        } else {
            return $numero;
        }
    }
}
