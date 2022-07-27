<?php

namespace App\Http\Controllers\ajax;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class consultaretController extends Controller
{
    public function consultaret(Request $request){

        $nome = $request->name;
        $retResponse = DB::connection('odbc-ret')->table('RET051')
        ->where("PRODNome",'LIKE',"%$nome%")
        ->get();

        return response()->json($retResponse);
    }
}
