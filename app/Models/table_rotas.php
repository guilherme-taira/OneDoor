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
        $data = table_rotas::groupby('remessa')->orderby('dateStart','desc')->get();
        return $data;
    }
}
