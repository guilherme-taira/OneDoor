<?php

namespace App\Http\Controllers\Order;

use App\Http\Controllers\Controller;
use App\Models\orders;
use App\Models\produtividade;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class OrderController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $orders = orders::getAllDataPaginate();
        return view('view.orders',[
            'orders' => $orders
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('view.cadastro');
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
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $order = orders::getAllDataByID($id);
        return view('view.edit',[
            'order' => $order
        ]);
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
        // echo "<pre>";
        // print_r($request->except('_token','_method'));

        $validator = Validator::make($request->all(),[
            'valor' => 'required|numeric|min:0',
            'fname' => 'required',
            'documento' => 'required',
            'telefone' => 'required|numeric|min:13',
            'email' => 'required|email',
            'endereco' => 'required',
            'bairro' => 'required',
            'uf' => 'required|max:2',
            'orcnum' => 'required|numeric',
        ]);

        $validator->errors();

        if ($validator->fails()) {
             return redirect()
                        ->back()
                        ->withErrors($validator)
                        ->withInput();
        }

        orders::where('ORCNUM',$request->orcnum)->update([
            'value' => $request->valor,
            'flag_erro' => '1',
            'Flag_Processado' => 'X',
        ]);

         User::where('id',$request->clientId)->update([
            'email' => $request->email,
            'documento' => $request->documento,
            'name' => $request->fname,
            'telefone' => $request->telefone,
            'endereco' => $request->endereco,
            'bairro' => $request->bairro,
            'uf' => $request->uf,
        ]);

        return redirect()->route('ordersFail')->with('msg',"Pedido Atualizado com Sucesso!");
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

    public function getProdutividade(){

        $produtividades = produtividade::getProdutividade();

        return view('view.produtividade.index',[
            'produtividades' => $produtividades
        ]);
    }
}
