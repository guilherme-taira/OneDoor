<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class table_rotas extends Model
{
    use HasFactory;

    protected $table = 'table_rotas';


    public static function getMaxRemessaID(){
        $data = table_rotas::select('remessa')->orderBy('remessa', 'desc')->first();
        return $data;
    }

    public static function getAllRotas(){
        $data = table_rotas::join('entregador','table_rotas.id_motorista','=','entregador.id')
        ->groupby('remessa')->orderby('dateStart','desc')->get();
        return $data;
    }

    public static function getFormDataOrder($motorista,$datainicial,$datafinal,$status){
        $data = table_rotas::join('users','table_rotas.cliente_id','=','users.id')
        ->join('orders','table_rotas.id','=','orders.client_id')
        ->join('entregador','table_rotas.id_motorista','=','entregador.id')
        ->select('entregador.name','users.name as cliente','ORCNUM','codcli','remessa','dateStart','dateFinished','value','tempoMedio');

        if($datainicial && $datafinal) {
            $data->whereBetween('table_rotas.created_at', [$datainicial.' 00:00:00', $datafinal.' 23:59:59']);
        }

        if($motorista){
            if($motorista == 0){
                $data->where('id_motorista','>','0');
            }else{
                $data->where('id_motorista',$motorista);
            }

        }

        if ($status) {
            switch ($status) {
                case '1':
                    $data->where('table_rotas.baixado','=','X');
                    break;
                case '2':
                    $data->whereNull('table_rotas.baixado');
                    break;
                default:
                     return $data->orderby('name','asc')->get();
                    break;
            }
        }

        return $data->orderby('name','asc')->get();
    }
}
