<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

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
        $produtividade = produtividade::all();
        return $produtividade;
    }

}
