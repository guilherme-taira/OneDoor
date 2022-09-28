<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <!-- MDB -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/mdb-ui-kit/4.2.0/mdb.min.css" rel="stylesheet" />
    <title>Relatóriod de Vendas</title>

    <style>
        table tr:nth-child(odd) td {
            background-color: rgb(255, 255, 255);
            color: rgb(12, 16, 20);
            border: 1px solid #000;
        }

        table tr:nth-child(even) td {
            background-color: rgb(223, 255, 62);
            border: 1px solid #000;
        }

        .vermelho {
            background-color: red;
        }

        .atencao-class {
            background-color: red;
            width: 20px;
            height: 20px;
            border-radius: 20px;
        }
    </style>
</head>

<body>

    <div class="card text-center lista-pagamentos">
        <div class="card-body">
            <h5 class="card-title">Embaleme</h5>
            <p class="card-text">Comércio de Embalagem e Festas</p>
        </div>

        <div class="card">
            <div class="card-header"> Relatório de Vendas - STATUS : {{$viewData['status']}}</div>
            <h5><span class="badge badge-light mt-2">Quantidade de Pedidos : {{ $viewData['quantidadePedidos']}} - data Inicial: {{$viewData['datainicial']}}
                     , dataFinal: {{$viewData['datafinal']}} </span></h5>
            <h5><span class="float-start badge badge-success mt-2"> Valor dos Pedidos R$: {{$viewData['total']}} </span></h5>
            <div class="card-body">
                <hr>
                <table class="table">
                    <thead>
                        <tr class="text-center">
                            <th scope="col">ORÇAMENTO</th>
                            <th scope="col">CLIENTE</th>
                            <th scope="col">COD CLI</th>
                            <th scope="col">REMESSA</th>
                            <th scope="col">DATA SAIDA</th>
                            <th scope="col">DATA BAIXA</th>
                            <th scope="col">VALOR</th>
                            <th scope="col">ENTREGADOR</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($viewData['orders'] as $order)
                        <tr class="text-center">
                            <td>{{$order->ORCNUM}}</td>
                            <td>{{substr($order->cliente,0, 30)}}</td>
                            <td>{{$order->codcli}}</td>
                            <td>{{$order->remessa}}</td>
                            <td>{{$order->dateStart}}</td>
                            <td>{{$order->dateFinished}}</td>
                            <td>{{$order->value}}</td>
                            <td>{{substr($order->name,0,-14)}}</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
                <hr>
            </div>
        </div>
    </div>
    <!-- MDB -->
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/mdb-ui-kit/4.2.0/mdb.min.js"></script>
</body>

</html>
