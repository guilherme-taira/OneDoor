<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\Order\CreateController;
use App\Http\Controllers\Order\GenerateNewOrderController;
use App\Models\orcamentodados;
use App\Models\orders;
use App\Models\produtividade;
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
        try {
            // CAIXA 10
            if (DB::connection('caixa10')) {
                $pesquisas = DB::connection('caixa10')->table('PAF06')
                    ->whereBetween('DATA', [$data, $data])
                    ->where('ORCAMENTO', '!=', null)
                    ->distinct()
                    ->select('ORCAMENTO', 'DATA', 'SAT_CHAVE', 'PDV', 'VENDEDOR')
                    ->get();

                foreach ($pesquisas as $value) {
                    //VERIFICA SE JÀ FOI CADASTRADO O ORÇAMENTO
                    if (orcamentodados::VerifyNewOrder($value['ORCAMENTO']) > 0) {
                        //echo "CADASTRADO COM SUCESSO!";
                        try {
                            // $newOrder = new orcamentodados();
                            // $newOrder->ORCNUM = $value['ORCAMENTO'];
                            // $newOrder->data = $value['DATA'];
                            // $newOrder->sat_chave = $value['SAT_CHAVE'];
                            // $newOrder->vendedor = $value['VENDEDOR'];
                            // $newOrder->terminal = $value['PDV'];
                            // $newOrder->save();
                            // ENVIA PARA A FILA O ORÇAMENTO
                            $this->GravaBancoDados(($value['ORCAMENTO']));
                            //\App\Jobs\sendOrcamentoViaApi::dispatch($value['ORCAMENTO']);
                        } catch (\Exception $e) {
                            //echo "Erro ao gerar o pedido Orçamento: " . $value['ORCAMENTO'];
                        }
                    }
                }
            }
        } catch (\Exception $e) {
            echo "CAIXA 10 DESCONECTADO!!";
        }
        // CAIXA 11
        try {
            // CAIXA 11
            if (DB::connection('caixa13')) {
                $pesquisas = DB::connection('caixa11')->table('PAF06')
                    ->whereBetween('DATA', [$data, $data])
                    ->where('ORCAMENTO', '!=', null)
                    ->distinct()
                    ->select('ORCAMENTO', 'DATA', 'SAT_CHAVE', 'PDV', 'VENDEDOR')
                    ->get();

                foreach ($pesquisas as $value) {
                    //VERIFICA SE JÀ FOI CADASTRADO O ORÇAMENTO
                    if (orcamentodados::VerifyNewOrder($value['ORCAMENTO']) > 0) {
                        //echo "CADASTRADO COM SUCESSO!";
                        try {
                            // $newOrder = new orcamentodados();
                            // $newOrder->ORCNUM = $value['ORCAMENTO'];
                            // $newOrder->data = $value['DATA'];
                            // $newOrder->sat_chave = $value['SAT_CHAVE'];
                            // $newOrder->vendedor = $value['VENDEDOR'];
                            // $newOrder->terminal = $value['PDV'];
                            // $newOrder->save();
                            // ENVIA PARA A FILA O ORÇAMENTO
                            $this->GravaBancoDados(($value['ORCAMENTO']));
                            //\App\Jobs\sendOrcamentoViaApi::dispatch($value['ORCAMENTO']);
                        } catch (\Exception $e) {
                            //echo "Erro ao gerar o pedido Orçamento: " . $value['ORCAMENTO'];
                        }
                    }
                }
            }
        } catch (\Exception $e) {
            echo "CAIXA 11 DESCONECTADO!!";
        }
        // CAIXA 13
        try {
            // CAIXA 13
            if (DB::connection('caixa13')) {
                $pesquisas = DB::connection('caixa13')->table('PAF06')
                    ->whereBetween('DATA', [$data, $data])
                    ->where('ORCAMENTO', '!=', null)
                    ->distinct()
                    ->select('ORCAMENTO', 'DATA', 'SAT_CHAVE', 'PDV', 'VENDEDOR')
                    ->get();

                foreach ($pesquisas as $value) {
                    //VERIFICA SE JÀ FOI CADASTRADO O ORÇAMENTO
                    if (orcamentodados::VerifyNewOrder($value['ORCAMENTO']) > 0) {
                        //echo "CADASTRADO COM SUCESSO!";
                        try {
                            // $newOrder = new orcamentodados();
                            // $newOrder->ORCNUM = $value['ORCAMENTO'];
                            // $newOrder->data = $value['DATA'];
                            // $newOrder->sat_chave = $value['SAT_CHAVE'];
                            // $newOrder->vendedor = $value['VENDEDOR'];
                            // $newOrder->terminal = $value['PDV'];
                            // $newOrder->save();
                            // ENVIA PARA A FILA O ORÇAMENTO
                            $this->GravaBancoDados(($value['ORCAMENTO']));
                            //\App\Jobs\sendOrcamentoViaApi::dispatch($value['ORCAMENTO']);
                        } catch (\Exception $e) {
                            //echo "Erro ao gerar o pedido Orçamento: " . $value['ORCAMENTO'];
                        }
                    }
                }

            }
        } catch (\Exception $e) {
            echo "CAIXA 13 DESCONECTADO!!";
        }


        $sendData = new GenerateNewOrderController();
        $sendData->NewOrder();

        // dados de orçamentos do dia
        $orcamentodados = orcamentodados::where('created_at', 'LIKE', '%' . $data . '%')->get();

        return view('view.gravapedidos', [
            'pedidos' => $orcamentodados
        ]);
    }


    public function consulta()
    {
        return view('view.consulta');
    }

    public function GravaBancoDados($ORCAMENTO)
    {

        $pesquisas = DB::connection('odbc-ret')->table('RET305')
            ->join('RET028', 'RET028.CLICod', '=', 'RET305.CLICOD')
            ->join('RET501', 'RET028.CIDCod', '=', 'RET501.CIDCod')
            ->select("CLINome", "CLICPF", "CLIRG", "CLICNPJ", "CLIEmail", "CLIEnd", "CLICep", "CLIBairro", "CLINUMERO", "CIDNome", "CIDUF", "CLIRef", "ORCNUM", "PRODTOTAL", "PRODQTDE", "ORCDESCONTO", "ORCHR", "CLIFone1", "CLIFone2")
            ->where('ORCNUM', '=', $ORCAMENTO)
            ->get();

        foreach ($pesquisas as $pesquisa) {
            $total = 0;
            $quantity_items = 0;

            $ORCAMENTO = $pesquisa['ORCNUM'];

            foreach ($pesquisas as $precos) {
                if ($ORCAMENTO == $precos['ORCNUM']) {
                    $total += $precos['PRODTOTAL'];
                    $quantity_items += $precos['PRODQTDE'];
                }
            }

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
                    $StoreData->value = $total;
                    $StoreData->quantity_items = $quantity_items;
                    $StoreData->ORCNUM = isset($ORCAMENTO) ? $ORCAMENTO : uniqid();
                    $StoreData->desconto = $pesquisa['ORCDESCONTO'];
                    $StoreData->HORASAIDA = $pesquisa['ORCHR'];
                    $StoreData->client_id = $NewUser->getID();
                    $StoreData->save();

                    // BAIXA O PEDIDO
                    produtividade::FinalyOrder($ORCAMENTO);
                }
            }
        }
    }



    public function TelefoneFilter(array $telefone)
    {
        $regex = "/ /";
        $replacement = "";

        if (strlen(preg_replace($regex, $replacement, $telefone['CLIFone1'])) < 11) {
            return '5599999999999';
        } else {
            $telefone = preg_replace($regex, $replacement, $telefone['CLIFone1']);
            return '55' . $telefone;
        }
    }


    public function countNumber($numero)
    {
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
            return trim($numero);
        }
    }
}

//"abram/laravel-odbc": "dev-master",
