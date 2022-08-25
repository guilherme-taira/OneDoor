<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use DateTime;
use Illuminate\Support\Facades\DB;

class produtividade extends Model
{
    use HasFactory;

    protected $table = 'produtividade';

    public static function VerifyNewOrcamento($order){
        $pesquisas = produtividade::where('orcamento',$order)->first();
        if($pesquisas){
            return 1;
        }else{
            return 0;
        }
    }

    public static function getAllOrders(){
        $produtividade = produtividade::
        where('flag_baixado','')
        ->orderBy('created_at','desc')->paginate(10);

        return $produtividade;
    }

    public static function FinalyOrder($ORCAMENTO){
        $data = produtividade::where('orcamento',$ORCAMENTO)->first();
        try {
            produtividade::where('id',$data->id)->update(['flag_baixado'=>'X']);
        } catch (\Exception $e) {
            return response()->json(['dados' => $e->getMessage()]);
        }
    }

    public static function getProdutividade(){
        $today = new DateTime();
        // $today->modify('-1 day');

        $data = DB::table('produtividade')
        ->select(DB::raw('count(*) as quantidade, nome'))
        ->join('vendedor','vendedor.id','=','produtividade.user_id')
        ->where('flag_separado','X')
        ->where('produtividade.created_at','LIKE','%'.$today->format('Y-m-d').'%')
        ->groupBy('user_id')
        ->orderBy('quantidade','desc')
        ->get();

        return $data;
    }

    public static function getProdutividadeDaily(){
        $today = new DateTime();

        $orders = DB::table('produtividade')
        ->select(DB::raw('count(*) as quantidade, nome, produtividade.created_at'))
        ->join('vendedor','vendedor.id','=','produtividade.user_id')
        ->where('flag_separado','X')
        ->where('produtividade.created_at','LIKE','%'.$today->format('Y-m-d').'%')
        ->groupBy('user_id')
        ->orderBy('quantidade','desc')
        ->get();

        $total = 0;
        foreach ($orders as $order) {
            $total += $order->quantidade;
        }

        return $total;
    }

    public static function getProdutividadeAllReport(){
        $today = new DateTime();

        $orders = DB::table('produtividade')
        ->select(DB::raw('count(*) as quantidade, nome, produtividade.created_at'))
        ->join('vendedor','vendedor.id','=','produtividade.user_id')
        ->where('flag_separado','X')
        ->where('produtividade.created_at','LIKE','%'.$today->format('Y-m').'%')
        ->groupBy('created_at')
        ->get();

        return $orders;
    }
}
