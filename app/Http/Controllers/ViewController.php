<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Order\CreateController;
use App\Http\Controllers\Order\GenerateNewOrderController;
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

    public function ordersFail(){

        $orders = orders::getAllOrderFailPaginate();
        return view('view.ordersFails',[
            'orders' => $orders
        ]);
    }


    public function gravapedidos()
    {
        $pesquisas = DB::connection('odbc-connection-name')->table('RET081')
            ->join('RET028', 'RET028.CLICod', '=', 'RET081.CLICod')
            ->join('RET501', 'RET028.CIDCod', '=', 'RET501.CIDCod')
            ->select("CLINome", "CLICPF", "CLIRG", "CLICNPJ", "CLIEmail", "CLIEnd", "CLICep", "CLIBairro", "CLINUMERO", "CIDNome", "CIDUF", "SAIQtde", "SAIVDA", "SAIDESCONTO", "CLIFone1", "CLIFone2", "CLIRef", "ORCNUM", "SAIData", "CLIBairro", "SAIHORA")
            ->whereBetween('SAIData', ['2022-07-19', '2022-07-19'])
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
                 print_r($pesquisa);

            } else {

                if (isset($ORCAMENTO)) {
                    print_r($pesquisa);

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

        //return view('view.');
    }

    public function storeDataDB($nome, $documento, $phoneNumber, $email, $Rua, $Cep, $Complemento, $Numero, $Cidade, $Estado, $preco)
    {
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
