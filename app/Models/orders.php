<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class orders extends Model
{
    use HasFactory;

    protected $table = 'orders';

    public function getID(){
        return $this->attributes['id'];
    }

    public function getCreatedAt(){
        return $this->attributes['created_at'];
    }

    public static function VerifyNewOrder($order){
        $pesquisas = orders::where('ORCNUM',$order)->first();
        if($pesquisas){
            return 1;
        }else{
            return 0;
        }
    }

    public static function getAllData(){
        $pesquisas = orders::join('users', 'orders.client_id', '=', 'users.id')
        ->get();

        return $pesquisas;
    }

    public static function getAllDataProcess(){
        $pesquisas = orders::join('users', 'orders.client_id', '=', 'users.id')
        ->where('Flag_Processado','X')
        ->limit(10)
        ->get();

        return $pesquisas;
    }

    public static function getAllDataPaginate(){
        $pesquisas = orders::join('users', 'orders.client_id', '=', 'users.id')->paginate(10);
        return $pesquisas;
    }

    public static function getAllOrderFailPaginate(){
        $pesquisas = orders::join('users', 'orders.client_id', '=', 'users.id')
        ->where('flag_erro','X')
        ->paginate(10);
        return $pesquisas;
    }

    public static function getAllDataByID($id){
        $pesquisas = orders::join('users', 'orders.client_id', '=', 'users.id')
        ->where('flag_erro','X')
        ->where('orders.id',$id)
        ->first();

        return $pesquisas;
    }

    public static function lastHourGet(){
        $hours = orders::latest()->first();
        $decode = json_decode($hours);
        return $decode->HORASAIDA;
    }
}
