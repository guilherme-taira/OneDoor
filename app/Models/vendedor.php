<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class vendedor extends Model
{
    use HasFactory;

    protected $table = 'vendedor';

    public static function getAllVendedor(){
        $vendedores = vendedor::all();
        return $vendedores;
    }
}
