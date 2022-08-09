<?php

namespace App\Http\Controllers\Ajax;

use App\Http\Controllers\Controller;
use App\Models\produtividade;
use Illuminate\Http\Request;

class SendOrderByColaborador extends Controller
{
    public function StoreProdutidade(Request $request){
        $data = produtividade::where('orcamento',$request->orcnum)->first();
       //produtividade::where('id',$data->id)->update(['colaborador' => $request->colaborador,'flag_separado'=>'X']);

        return response()->json(['dados' => $data],200);
    }
}
