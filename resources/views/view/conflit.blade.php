@extends('view.layout')
@section('content')
<meta name="csrf-token" content="{{ csrf_token() }}" />
    <div class="container">
        <section class="ftco-section">
            <div class="container">
                <div class="row justify-content-center">
                    <div class="col-md-6 text-center mb-4">
                        <h2 class="heading-section">Pedidos Em Aberto <div class="mt-4" id="loader"></div>
                        </h2>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-3">
                        <a href="{{route('getProdutividade')}}"><button type="button" class="btn btn-warning">
                            <i class="bi bi-bar-chart-line"></i>  Produtividade Total: <span class="badge bg-secondary">{{$total}}</span>
                        </button></a>
                    </div>
                    <div class="col-md-12">
                        <div class="table-wrap">
                            <table class="table myaccordion table-hover" style="padding: 50px;" id="accordion">
                                <thead>
                                    <tr class="text-center">
                                        <th>Nº Cupom</th>
                                        <th>Status</th>
                                        <th>Data</th>
                                        <th>Hora</th>
                                        <th>Cliente</th>
                                        <th>Vendedor</th>
                                        <th>Colaborador</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($dados as $order)
                                        @if (isset($order['Error']))
                                            <div class="alert alert-danger">{{ $order['Error'] }}</div>
                                        @else
                                            @if($order['flag_separado'] == 'X')
                                            <tr id="linhaSeparado">
                                                <td><input type="text"
                                                        value="{{ $order['orcamento'] }}"name="orcamentoID"
                                                        id="orcamentoID"></th>
                                                <td class="badge bg-warning mt-1">SEPARAÇÃO</td>
                                                <td class="text-center">{{ $order['dataorcamento'] }}</td>
                                                <td class="text-center">{{ $order['orcamentohora'] }}</td>
                                                <td class="text-center">{{ $order['cliente'] }}</td>
                                                <td class="text-center">{{ $order['Nvendedor'] }}</td>
                                                <td>
                                                    <select class="form-select" id="colaboradorSelect"
                                                        aria-label="Default select example">
                                                        @if (count($vendedores) > 0)
                                                            @foreach ($vendedores as $vendedor)
                                                                @if($order['user_id'] == $vendedor->id)
                                                                <option value="{{ $vendedor->id }}">{{ $vendedor->nome }}</option>
                                                                @endif
                                                            @endforeach
                                                        @else
                                                            <option value="1">DEFAULT</option>
                                                        @endif
                                                    </select>
                                                </td>
                                            </tr>
                                            @else
                                            <tr id="linhaPedido">
                                                <td><input type="text"
                                                        value="{{ $order['orcamento'] }}"name="orcamentoID"
                                                        id="orcamentoID"></th>
                                                <td class="badge bg-danger mt-1">EM ABERTO</td>
                                                <td class="text-center">{{ $order['dataorcamento'] }}</td>
                                                <td class="text-center">{{ $order['orcamentohora'] }}</td>
                                                <td class="text-center">{{ $order['cliente'] }}</td>
                                                <td class="text-center">{{ $order['Nvendedor'] }}</td>
                                                <td>

                                                    <select class="form-select" id="colaboradorSelect"
                                                        aria-label="Default select example">
                                                        <option value="" selected>Selecione..</option>
                                                        @if (count($vendedores) > 0)
                                                            @foreach ($vendedores as $vendedor)
                                                                <option value="{{ $vendedor->id }}">{{ $vendedor->nome }}
                                                                </option>
                                                            @endforeach
                                                        @else
                                                            <option value="1">DEFAULT</option>
                                                        @endif
                                                    </select>
                                                </td>
                                            </tr>
                                            @endif
                                        @endif
                                    @endforeach

                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>
@endsection

<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.js"></script>
<link href="https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.11.4/jquery-ui.css" rel="stylesheet" />
<link href="https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.11.4/jquery-ui.theme.css" rel="stylesheet" />
<script src="https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.11.4/jquery-ui.js"></script>

<script>
    $(document).ready(function() {
        $('#loader').addClass('loader');
        // TOKEN DE ASSINATURA
        let _token = $('meta[name="csrf-token"]').attr('content');

        const orcamento = $('input[name=orcamentoID]');
        const linhaPedido = $('tr#linhaPedido');

        $('select').each(function(item, i) {
            $(i).change(function() {

                const ORCNUM = $(orcamento[item]).val();
                const COLABORADOR = $(i).val();
                const LINHA = $(linhaPedido[item]).text();

                $.ajax({
                    url: "/SendOrderByColaborador",
                    type: "POST",
                    data: {
                        orcnum: ORCNUM,
                        colaborador: COLABORADOR,
                        _token: _token,
                    },
                    beforeSend: function() {
                        $("#loaderDiv").show();
                    },
                    success: function(response) {
                        // mostra os dados de retorno
                        window.location.reload();
                    },
                    error: function(error) {
                        console.log(error);
                    }
                });

            });
        });


        window.setTimeout(function() {
            window.location.reload();
        }, 30000);
    });
</script>
