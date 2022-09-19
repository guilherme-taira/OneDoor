@extends('view.layout')
@section('content')
    <div class="container">
        <section class="ftco-section">
            <div class="container">
                <div class="row justify-content-center">
                    <div class="col-md-6 text-center mb-4">
                        <h2 class="heading-section" id="loader">Pedidos no Finan</h2>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12">
                        <div class="table-wrap">
                            <table class="table myaccordion table-hover" style="padding: 50px;" id="accordion">
                                <thead>
                                    <tr>
                                        <th>Orçamento</th>
                                        <th>Cupom Fiscal</th>
                                        <th>Cliente</th>
                                        <th>Valor</th>
                                        <th>Chave SAT</th>
                                        <th>Cliente</th>
                                        <th>Cadastrado</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($orders as $order)
                                    <tr>
                                        <td>{{$order->ORCNUM}}</td>
                                        <td>{{$order->cupomFiscal}}</td>
                                        <td>{{$order->codcli}}</td>
                                        <td>{{$order->value}}</td>
                                        <td>{{$order->sat_chave}}</td>
                                        <td>{{$order->name}}</td>
                                        <td>{{$order->created_at}}</td>
                                    </tr>
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

        window.setTimeout(function() {
            window.location.reload();
        }, 30000);
    });
</script>
