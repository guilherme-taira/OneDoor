<?php

namespace App\Http\Controllers\ajax;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class GetallOrderByClientId extends Controller
{
    public function getAllDataOrderClientById(Request $request){
        $data = json_encode(User::select('name','id')->where('codcli','LIKE','%'.$request->name.'%')->groupby('name')->get());
        //$data = json_encode(DB::connection('odbc-ret')->table('RET028')->where("CLICod","$request->name")->get());
        if($data){
            return response()->json(['dados' => $data],200);
        }
        return response()->json(['dados' => 'Error: Não Há Cliente Com esse Nome '.$request->name]);
    }
}
