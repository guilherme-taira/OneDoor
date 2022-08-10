<?php

namespace App\Http\Controllers\Ajax;

use App\Http\Controllers\Controller;
use App\Models\produtividade;
use Illuminate\Http\Request;

class SendOrderByColaborador extends Controller
{
    public function StoreProdutidade(Request $request){
        $data = produtividade::where('orcamento',$request->orcnum)->first();
        try {
            produtividade::where('id',$data->id)->update(['user_id' => $request->colaborador,'flag_separado'=>'X']);
        } catch (\Exception $e) {
            return response()->json(['dados' => $e->getMessage()]);
        }

        return response()->json(['dados' => $data->id],200);
    }
}
