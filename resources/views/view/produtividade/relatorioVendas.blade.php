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
            <div class="card-header"> Relatório de Vendas - STATUS : {{ $viewData['status'] }}</div>
            <h5><span class="badge badge-light mt-2">Quantidade de Pedidos :{{ $viewData['pedidos'] }} - data Inicial:
                    {{ $viewData['datainicial'] }} , dataFinal: {{ $viewData['datafinal'] }} </span></h5>
            <h5><span class="float-start badge badge-success mt-2"> Valor dos Orçamentos R$: {{ $viewData['bruto'] }} ,
                    Pago R$: {{ $viewData['liquido'] }} </span></h5>
            <div class="card-body">
                <hr>
                <table class="table">
                    <thead>
                        <tr class="text-center">
                            <th scope="col">ORÇAMENTO</th>
                            <th scope="col">COD CLI</th>
                            <th scope="col">Nº Cupom</th>
                            <th scope="col">Hora Pedido</th>
                            <th scope="col">Valor Orçamento</th>
                            <th scope="col">Pago R$</th>
                            <th scope="col">Forma Pagamento</th>
                            <th scope="col">Nome Cliente</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($viewData['vendas'] as $venda)
                            <tr class="text-center">
                                {{ GetCupom::getCupomSaida($venda['ORCNUM']) }}
                                <td>{{ $venda['ORCNUM'] }}</td>
                                <td>{{ $venda['codcli'] }}</td>
                                <td class="{{ empty($venda['cupomFiscal']) ? 'vermelho' : '' }}">
                                    {{ isset($venda['cupomFiscal']) ? $venda['cupomFiscal'] : ' - ' }}</td>
                                <td>{{ $venda['HORASAIDA'] }}</td>
                                <td>{{ $venda['value'] }} R$</td>
                                <td class="{{ empty($venda['cupomFiscal']) ? 'vermelho' : '' }}">
                                    {{ isset($venda['valorPago']) ? "{$venda['valorPago']} R$" : ' - ' }}</td>
                                <td>{{ $venda['formaPagamento'] }}</td>
                                <td>{{ $venda['name'] }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
                <hr>

                <!--- LISTA DOS VALORES ---->
                <ul class="list-group">
                    <li class="list-group-item d-flex justify-content-between align-items-center">
                        Dinheiro: R$ {{$viewData['dinheiroTotal']}}
                    </li>
                    <li class="list-group-item d-flex justify-content-between align-items-center">
                        Cartão: R$ {{$viewData['cartaoTotal']}}
                    </li>
                    <li class="list-group-item d-flex justify-content-between align-items-center">
                        Pix: R$ {{$viewData['pixTotal']}}
                    </li>
                    <li class="list-group-item d-flex justify-content-between align-items-center">
                        Boleto: R$ {{$viewData['boletoTotal']}}
                    </li>
                </ul>
                <!---- FINAL DA LISTAS ----->
            </div>
        </div>
    </div>
    <!-- MDB -->
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/mdb-ui-kit/4.2.0/mdb.min.js"></script>
</body>

</html>
