@extends('view.layout')
@section('content')
    <div class="container">
        <section class="ftco-section">
            <div class="container">
                <div class="row justify-content-center">
                    <div class="col-md-6 text-center mb-4">
                        <h2 class="heading-section">Motoristas - Expedição<div class="mt-4"></div>
                        </h2>
                    </div>
                </div>
                <div class="row">

                    @if (session('msg'))
                        <div class="alert alert-success" role="alert">
                            {{ session('msg') }}
                        </div>
                    @endif

                    <div class="col-md-2 py-2">
                        <a href="{{ route('motorista.create') }}" class="btn btn-success">Novo Motorista <i
                                class="bi bi-person-plus-fill"></i></a>
                    </div>

                    <div class="col-md-12">
                        @if (count($entregadores) > 0)
                            <table class="table myaccordion table-hover mt-4" style="padding: 50px;" id="accordion">
                                <thead>
                                    <tr class="text-center">
                                        <th>ID</th>
                                        <th>Nome</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($entregadores as $entregador)
                                        <tr>
                                            <th scope="row">{{ $entregador->id }}</th>
                                            <td class="text-center">{{ $entregador->name }}</td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        @else
                            <!---- ALERT DANGER NÃO HÁ USUARIOS CADASTRADO ---->
                            <div class="alert alert-danger">Não Há Motoristas Cadastrado!</div>
                        @endif
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
