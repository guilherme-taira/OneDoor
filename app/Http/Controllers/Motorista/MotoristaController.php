<?php

namespace App\Http\Controllers\Motorista;

use App\Http\Controllers\Controller;
use App\Models\entregador;
use App\Models\table_rotas;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Validator;

class MotoristaController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $entregadores = entregador::paginate(10);

        return view('view.motorista.index', [
            'entregadores' => $entregadores
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $entregadores = entregador::all();

        return view('view.motorista.create', [
            'entregadores' => $entregadores,
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'nome' => 'required|min:3',
        ]);

        $validator->errors();

        if ($validator->fails()) {
            return redirect()
                ->back()
                ->withErrors($validator)
                ->withInput();
        }

        $motorista = new entregador();
        $motorista->name = $request->input('nome');
        $motorista->save();

        return redirect()->route('motorista.index')->with('msg', 'Motorista Cadastrado com Sucesso!');
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

    public function generateReportMotorista(Request $request)
    {

        print_r($request->all());

        $dados = table_rotas::getFormDataOrder($request->motorista, $request->datainicial, $request->datafinal, $request->status);

        $viewData = [];
        $viewData['orders'] = $dados;
        $viewData['status'] = $this->getStatus($request->status);
        $viewData['total'] = $this->total($dados);
        $viewData['datainicial'] = $request->datainicial;
        $viewData['datafinal'] = $request->datafinal;
        $viewData['quantidadePedidos'] = $this->QuantidadePedidos($dados);

        $pdf = App::make('dompdf.wrapper');
        $pdf->setPaper('A4', 'landscape');
        $pdf->loadView('view.produtividade.relatorioMotorista', [
            'viewData' => $viewData,
        ]);

        return $pdf->stream();
    }

    public function getStatus($status)
    {
        switch ($status) {
            case '1':
                return "FINALIZADOS";
                break;
            case '2':
                return "AGUARDANDO";
                break;
        }
    }

    public function total($dados){
        $total = 0;
        foreach ($dados as $dado) {
            $total += $dado->value;
        }
        return $total;
    }

    public function QuantidadePedidos($dados){
        $total = 0;
        $i = 1;
        foreach ($dados as $dado) {
            $total += $i;
        }
        return $total;
    }
}

