<?php

namespace App\Http\Controllers\Rotas;

use App\Http\Controllers\Controller;
use App\Models\orders;
use App\Models\table_rotas;
use App\Models\table_status;
use Illuminate\Http\Request;

class RotaController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $request->session()->forget(['_flash', '_token', '_previous']);
        $data = $request->session()->all();

        return view('view.rotas', [
            'pedidos' => $data
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $remessa = table_rotas::where('remessa',$id)->join("users","table_rotas.cliente_id","=","users.id")->get();
        return view('view.listRemessaOrders',['remessas' => $remessa]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        echo $id;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    public function setSessionRoute(Request $request)
    {

        $request->session()->forget(['_flash', '_token', '_previous']);

        try {
            $data = $request->session()->all();
            $codigoCliente = $request->input('user');

            $i = 0;
            $chaves = [];
            foreach ($data as $value) {
                $chaves[$i] = $value['codigo'];
                $i++;
            }

            if (!in_array($codigoCliente, $chaves)) {
                $request->session()->put($request->user, ['codigo' => $request->user, 'nome' => $request->name]);
            } else {
                $request->session()->forget($codigoCliente);
            }
        } catch (\Exception $e) {
            echo $e->getMessage();
        }


        return view('view.rotas', [
            'pedidos' =>  $data,
        ]);
    }


    public function DeleteOrderSessionRoute(Request $request)
    {

        $request->session()->forget(['_flash', '_token', '_previous']);

        try {

            echo "<pre>";
            print_r($request->session()->all());

            $data = $request->session()->all();
            $codigoCliente = $request->id;

            $i = 0;
            $chaves = [];
            foreach ($data as $value) {
                $chaves[$i] = $value['codigo'];
                $i++;
            }

            //unset($variable)
            if (in_array($codigoCliente, $chaves)) {
                $dados = array_keys($chaves,$codigoCliente);
                foreach ($dados as $pos) {
                    $request->session()->forget($pos);
                }

            }

            return back();
        } catch (\Exception $e) {
            echo $e->getMessage();
        }
    }


    public function StoreRota(Request $request){
        $request->session()->forget(['_flash', '_token', '_previous']);

        $datas = $request->session()->all();

        $id = uniqid('EMBALEME');

        $lastRemessa = table_rotas::getMaxRemessaID();

        foreach ($datas as $data) {
            $StoreRota = new table_rotas();
            $StoreRota->id_rota = $id;
            $StoreRota->cliente_id = $data['codigo'];
            $StoreRota->remessa = isset($lastRemessa->remessa) ? $lastRemessa->remessa + 1 : 1;
            $StoreRota->save();
        }

        $datas = $request->session()->flush();

        return view('view.rotas',['pedidos' => $datas]);
    }
}
