<?php

namespace App\Http\Controllers\ajax;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

class GetallOrderByClientId extends Controller
{
    public function getAllDataOrderClientById(Request $request){
        $data = json_encode(User::select('name','id')->where('codcli','LIKE','%'.$request->name.'%')->groupby('name')->get());

        if($data){
            return response()->json(['dados' => $data],200);
        }
        return response()->json('Error: Não Há Produtos Com esse Nome',404);
    }
}
