@extends('view.layout')
@section('content')
    <div class="container">
        <section class="ftco-section">
            <div class="container">
                <div class="row justify-content-center">
                    <div class="col-md-6 text-center mb-4">
                        <h2 class="heading-section" id="loader">Pedidos </h2>
                    </div>

                    <div class="card" style="width: 18rem;">
                        <div class="card-header bg-primary">
                            PDV LOGADOS
                        </div>
                        <ul class="list-group list-group-flush">
                            @foreach ($pdvs as $pdv)
                                @if(isset($pdv['erro']))
                                    <li class="badge bg-danger mt-2 py-2">{{$pdv['erro']}}</li>
                                @else
                                    <li class="badge bg-success mt-2 py-2">{{$pdv}} </li>
                                @endif
                            @endforeach
                        </ul>
                        </div>
                </div>
                <div class="row">
                    <div class="col-md-12">
                        <div class="col-md-3">
                            <a href="{{ route('getProdutividade') }}"><button type="button" class="btn btn-warning btn-sm text-decoration-none"><i class="bi bi-bar-chart-line"></i> Baixar Pedidos</button></a>
                            <a href="{{ route('reportProdutividade') }}"><button type="button" class="btn btn-success btn-sm text-decoration-none"><i class="bi bi-book"></i> Relatórios</button></a>
                        </div>
                        <div class="table-wrap">
                            <table class="table myaccordion table-hover" style="padding: 50px;" id="accordion">
                                <thead>
                                    <tr>
                                        <th>Orçamento</th>
                                        <th>Data</th>
                                        <th>SAT Chave</th>
                                        <th>Terminal</th>
                                        <th>Vendendor</th>
                                        <th>Cadastrado</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($pedidos as $order)
                                        <tr>
                                            <th scope="row">{{ $order->ORCNUM }}</th>
                                            <td>{{ $order->data }}</td>
                                            <td>{{ $order->sat_chave }}</td>
                                            <td>{{ $order->terminal }}</td>
                                            <td>{{ $order->vendedor }}</td>
                                            <td>{{ $order->created_at }}</td>
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
