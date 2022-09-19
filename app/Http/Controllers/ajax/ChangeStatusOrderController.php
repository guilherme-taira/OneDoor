<?php

namespace App\Http\Controllers\ajax;

use App\Http\Controllers\Controller;
use App\Models\orders;
use Illuminate\Http\Request;

class ChangeStatusOrderController extends Controller
{
    public function ChangeStatus(Request $request)
    {
        // MUDA STATUS POR NUMERO
        switch ($request->status) {
            case '1': // FINALIZADO
                  orders::where('ORCNUM',$request->orcnum)->update(['flag_finalizado' => '1','flag_aguardando' => '','flag_cancelado' => '']);
                  return response()->json(['dados' => $request->all()], 200);
                break;
            case '2': // AGUARDANDO
                orders::where('ORCNUM',$request->orcnum)->update(['flag_finalizado' => '','flag_aguardando' => '2','flag_cancelado' => '']);
                return response()->json(['dados' => $request->all()], 200);
                break;
            case '3': // CANCELADO
                orders::where('ORCNUM',$request->orcnum)->update(['flag_finalizado' => '','flag_aguardando' => '','flag_cancelado' => '3']);
                return response()->json(['dados' => $request->all()], 200);
                break;
            default:
                # code...
                break;
        }
    }
}
