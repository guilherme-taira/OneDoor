<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\orders;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class OrdersController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $orders = orders::getAllData();
        return response()->json($orders);
    }


    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //unique:App\Models\send_api_data_uello,keyNF
        $validator = Validator::make($request->all(),[
            'number' => 'required|numeric|min:1',
            'forecastDeliveryDate' => 'required|date', // data prevista para chegar o pedido
            'total' => 'required|numeric',
            // payment
            'prepaid' => 'required|numeric', //valor pré-pago
            'pending' => 'required|numeric', // valor pendente
            'type' => 'required',
            'method' => 'required',
            'changeFor' => 'required|numeric', // troco
            // Destinatário
            'name' => 'required',
            'document' => 'required|numeric',
            'numeroLojaVirtual' => 'numeric',
            'phoneNumber' => 'required|numeric',
            'email' => 'required',
            'street' => 'required',
            'zipCode' => 'required|numeric',
            'district' => 'required',
            'city' => 'required',
            'state' => 'required|max:2',
            // location
            'latitude' => 'required',
            'longitude' => 'required',
            // items

            'description' => 'required',
            'quantity' => 'required|numeric',
            'price' => 'required|numeric',
        ]);

        $errors = $validator->errors();

        if ($validator->fails()) {
            return response()->json($errors,422);
        }

        echo "CADASTRADO COM SUCESSO!";
        // SAVE DATA FROM TABLE SEND API DATA UELLO ##
        // $data = new send_api_data_uello();
        // $data->numberNF = $request->numberNF;
        // $data->serieNF = $request->serieNF;
        // $data->valueNF = $request->valueNF;
        // $data->keyNF = $request->keyNF;
        // $data->NUMORC = $request->NUMORC;
        // $data->link = $request->link;
        // $data->xmlDanfe = $request->xmlDanfe;
        // $data->product_id = $request->product_id;
        // $data->variation_id = $request->variation_id;
        // $data->cfop = $request->cfop;
        // $data->numeroLojaVirtual = $numeroLojaVirtual;
        // $data->dataEmissao = $request->dataEmissao;
        // $data->save();

        // if($data){
        //     logs::create([
        //         'message' => "Pedido Cadastrado com Sucesso! Nº: " . $request->keyNF,
        //         'dadosFiscais' => "$data->id",
        //         'plataforma' => '3',
        //     ]);
        // }
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
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
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

    public function storeDataDB(){

    }

}
