<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class orcamentodados extends Model
{
    use HasFactory;

    protected $table = 'orcamentodados';

    public static function VerifyNewOrder($order){
        $pesquisas = orcamentodados::where('ORCNUM',$order)->first();
        if($pesquisas){
            return 1;
        }else{
            return 0;
        }
    }
}
