<?php

namespace App\Http\Controllers\Order;

use App\Http\Controllers\Controller;
use App\Models\orders;
use App\Models\produtividade;
use App\Models\table_status;
use App\Models\User;
use App\Models\vendedor;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Validator;
use Barryvdh\DomPDF\Facade\Pdf;
use Dompdf\Dompdf;


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
        $status = table_status::all();


        return view('view.orders',[
            'orders' => $orders,
            'status' => $status
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

    public function reportProdutividade(){
        $vendedores = vendedor::getAllVendedor();

        return view('view.produtividade.report',[
            'vendedores' => $vendedores
        ]);
    }

    public function generateprodutividadereport(){

        $dados = produtividade::getProdutividadeAllReport();
        echo "<pre>";

        $data = [];
        $nomes = [];
        $quantidades = [];

        $i = 0;
        foreach ($dados as $value) {
           if(!in_array(substr($value->created_at,0,10),$data)){
                 $data[$i] = substr($value->created_at,0,10);
                 $i++;
           }
        }

        $i = 0;
        foreach ($dados as $value) {
            if(!in_array($value->nome,$nomes)){
                  $nomes[$i] = $value->nome;
                  $i++;
            }
         }

        for ($j = 0; $j < count($data); $j++) {
            for ($i = 0; $i < count($nomes); $i++) {
                $total = 0;
                foreach ($dados as $value) {
                    if($data[$j] == substr($value->created_at,0,10))
                    if ($nomes[$i] == $value->nome) {
                        $total += $value->quantidade;
                    }
                }
                $quantidades[$j]  = $total;

                $arrays[$i][$j] = [
                    'colaborador' => $nomes[$i],
                        'Data' => $data[$j],
                            'Quantidade' => $quantidades[$j],
                ];
            }
        }


        $pdf = App::make('dompdf.wrapper');
        $pdf->loadView('view.produtividade.responseReport',[
            'dados' => $arrays
        ]);

        return $pdf->stream();
    }

    public function getEtiquetas(Request $request){

        print_r($request->all());

        $validator = Validator::make($request->all(),[
            'orcamento' => 'required|numeric|min:0',
            'volumes' => 'required|numeric',
        ]);

        $validator->errors();

        if ($validator->fails()) {
             return redirect()
                        ->back()
                        ->withErrors($validator)
                        ->withInput();
        }

        //QUERY SQL
        $order = orders::join('users','users.id','=','orders.client_id')
        ->where('ORCNUM',$request->orcamento)->get();

        $pdf = App::make('dompdf.wrapper');
        $pdf->setPaper('A6');
        $pdf->loadView('view.produtividade.etiqueta',[
            'dados' => $order,
            'volumes' => $request->volumes,
            'observacao' => $request->observacao,
        ]);

       return $pdf->stream();
    }


    public function getWaitingOrder(){

        // PEGA TODOS OS PEDIDSO EM AGUARDANDO
        $orders = orders::getWaitingOrders();

        return view('view.baixaPedido',[
            'orders' => $orders,
        ]);
    }

    public function UpdatePaymentForm(Request $request){
       $atualizacao =  orders::where('ORCNUM',$request->OrcNum)->update(['formaPagamento' => $request->PaymentForm]);
       if($atualizacao){
          return redirect()->back()->with('msg', 'Pedido Atualizado com Sucesso!');
       }
       return redirect()->back()->with('msg', 'Pedido Atualizado com Sucesso!');
    }
}
