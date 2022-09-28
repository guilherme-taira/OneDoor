<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class orders extends Model
{
    use HasFactory;

    protected $table = 'orders';

    public function getID()
    {
        return $this->attributes['id'];
    }

    public function getCreatedAt()
    {
        return $this->attributes['created_at'];
    }

    public static function VerifyNewOrder($order)
    {
        $pesquisas = orders::where('ORCNUM', $order)->first();
        if ($pesquisas) {
            return 1;
        } else {
            return 0;
        }
    }

    public static function getAllData()
    {
        $pesquisas = orders::join('users', 'orders.client_id', '=', 'users.id')
            ->get();

        return $pesquisas;
    }

    public static function getAllDataProcess()
    {
        $pesquisas = orders::join('users', 'orders.client_id', '=', 'users.id')
            ->where('Flag_Processado', 'X')
            ->limit(10)
            ->get();

        return $pesquisas;
    }

    public static function getAllDataPaginate()
    {
        $pesquisas = orders::join('users', 'orders.client_id', '=', 'users.id')
        ->orderBy('orders.id', 'desc')
        ->paginate(10);
        return $pesquisas;
    }

    public static function getOneDatePaginate($orcnum){
        $pesquisas = orders::join('users', 'orders.client_id', '=', 'users.id')
        ->where('ORCNUM',$orcnum)
        ->paginate(1);
        return $pesquisas;
    }

    public static function getAllOrderFailPaginate()
    {
        $pesquisas = orders::join('users', 'orders.client_id', '=', 'users.id')
            ->where('flag_erro', 'X')
            ->paginate(10);
        return $pesquisas;
    }

    public static function getAllDataByID($id)
    {
        $pesquisas = orders::join('users', 'orders.client_id', '=', 'users.id')
            ->where('flag_erro', 'X')
            ->where('orders.id', $id)
            ->first();

        return $pesquisas;
    }

    public static function lastHourGet()
    {
        $hours = orders::latest()->first();
        $decode = json_decode($hours);
        return $decode->HORASAIDA;
    }


    public static function listAllOrderFinished($datainicial, $datafinal, $caixa, $status)
    {
        /**
         *  LISTA TODOS OS PEDIDOS QUE NÃO ESTÃO BAIXADOS
         */
        $data = orders::join('orcamentodados', 'orders.ORCNUM', '=', 'orcamentodados.ORCNUM')
            ->join('users', 'orders.client_id', '=', 'users.id');

        if ($datainicial && $datafinal) {
            $data->whereBetween('orcamentodados.data', [$datainicial, $datafinal]);
        }

        if ($caixa) {
            $data->where('orcamentodados.terminal', $caixa);
        }

        if ($status) {
            switch ($status) {
                case '1':
                    $data->where('orders.flag_finalizado', '1');
                    break;
                case '2':
                    $data->where('orders.flag_aguardando', '2');
                    break;
                case '3':
                    $data->where('orders.flag_cancelado', '3');
                    break;
                default:
                    //# code...
                    break;
            }
        }

        $data->orderby('name','asc');

        return $data->get();
    }


    public static function getWaitingOrders()
    {
        // RECEBE TODOS OS PEDIDOS QUE ESTÃO AGUARDANDO SER TRATADO
        $data = orders::where('orders.flag_aguardando', '=', 'X')
            ->join('orcamentodados', 'orders.ORCNUM', '=', 'orcamentodados.ORCNUM')
            ->join('users', 'orders.client_id', '=', 'users.id')
            ->paginate(10);

        return $data;
    }

    /**
     *  FUNÇÕES QUE IRA USAR DENTRO DO DOMPDF
     */

    public static function getCupomSaida($ORCAMENTO)
    {
        try {
            $pesquisas = DB::connection('odbc-ret')->table('RET081')
                ->select("SAICupom", "ORCNUM","CLICod")
                ->where('ORCNUM', $ORCAMENTO)
                ->distinct()
                ->get();

            if ($pesquisas) {
                try {
                    orders::where('ORCNUM', $ORCAMENTO)->update(['cupomFiscal' => $pesquisas[0]['SAICupom']]);
                } catch (\Exception $e) {
                    $valor = 0;
                }
                orders::where('ORCNUM', $ORCAMENTO)->update(['cupomFiscal' => $pesquisas[0]['SAICupom']]);
            }
            //return $pesquisas;
        } catch (\Exception $e) {
            //echo $e->getMessage();
        }
    }

    /**
     * GET VALOR DA TABELA DE RECEBIVEIS
     */

     public static function getValueRET092($cupom,$clicod){

        try {
            $pesquisas = DB::connection('odbc-ret')->table('RET092')
            ->select("RECVLR", "RECDoc","CLICod")
            ->where('RECDoc', $cupom)
            ->where('CLICod',$clicod)
            ->distinct()
            ->get();

            return $pesquisas;
        } catch (\Exception $e) {
            echo $e->getMessage();
        }

     }

     public static function VerificaCampoCupom($ORCAMENTO){
        $data = orders::where('ORCNUM',$ORCAMENTO)->where('valorPago','')->first();
        return empty($data->valorPago) ? 1 : 0;
     }


    // LISTA O TOTAL DE TODAS AS FORMAS DE PAGAMENTO
    public static function getTotalPaymentForms($datainicial, $datafinal, $caixa, $status){

        $data = orders::select('valorPago','formaPagamento','terminal','orders.ORCNUM')->join('orcamentodados', 'orders.ORCNUM', '=', 'orcamentodados.ORCNUM');

        if($datainicial && $datafinal) {
            $data->whereBetween('orders.created_at', [$datainicial.' 00:00:00', $datafinal.' 23:59:59']);
        }

        if($caixa) {
            $data->where('orcamentodados.terminal', $caixa);
        }

        if ($status) {
            switch ($status) {
                case '1':
                    $data->where('orders.flag_finalizado', '1');
                    break;
                case '2':
                    $data->where('orders.flag_aguardando', '2');
                    break;
                case '3':
                    $data->where('orders.flag_cancelado', '3');
                    break;
            }
        }

        return $data->get();

    }
}
