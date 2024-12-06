@extends('view.layout')
@section('content')
    <meta name="csrf-token" content="{{ csrf_token() }}" />
    <div class="container">
        <section class="ftco-section">
            <div class="container">
                <div class="row justify-content-center">
                    <div class="col-md-6 text-center mb-4">
                        <h2 class="heading-section">Gerador de Rotas <svg xmlns="http://www.w3.org/2000/svg" width="64"
                                height="64" fill="currentColor" class="bi bi-box-seam-fill" viewBox="0 0 16 16">
                                <path fill-rule="evenodd"
                                    d="M15.528 2.973a.75.75 0 0 1 .472.696v8.662a.75.75 0 0 1-.472.696l-7.25 2.9a.75.75 0 0 1-.557 0l-7.25-2.9A.75.75 0 0 1 0 12.331V3.669a.75.75 0 0 1 .471-.696L7.443.184l.01-.003.268-.108a.75.75 0 0 1 .558 0l.269.108.01.003 6.97 2.789ZM10.404 2 4.25 4.461 1.846 3.5 1 3.839v.4l6.5 2.6v7.922l.5.2.5-.2V6.84l6.5-2.6v-.4l-.846-.339L8 5.961 5.596 5l6.154-2.461L10.404 2Z" />
                            </svg></h2>
                    </div>
                </div>

                <!--- MODAL QUE SELECIONA O MOTORISTA --->

                <div class="modal-dialog modal-xl">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title text-dark" id="exampleModalLabel">Motorista <i
                                        class="bi bi-bookmarks"></i>
                                </h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal"
                                    aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                <p class="text-dark">Selecione o Motorista Abaixo</p>

                                <div class="col-md-6">
                                    <a href="{{route('motorista.create')}}"><button class="btn btn-primary btn-sm"> Novo Motorista <i class="bi bi-person-plus"></i></button></a>
                                </div>

                                <form action="{{ route('StoreRota') }}"  method="GET">
                                    @csrf
                                    <div class="col-md-12">
                                        <!-- SELECT DO MOTORISTA -->
                                        <label class="form-label" for="form8Example1">Status da Venda</label>
                                        <select class="form-select" name="entregador" required class="form-control">
                                            <option selected value="">Todos...</option>
                                            @foreach ($entregadores as $entregador)
                                                <option value="{{ $entregador->id }}">{{ $entregador->name }}</option>
                                            @endforeach
                                        </select>
                                        <!--- FIM --->
                                    </div>
                                    <div class="modal-footer">
                                        <input type="submit" class="btn btn-success"
                                            value="Finalizar Rota"></button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>

                <!--- FINAL DO MODAL ---->

                <!---- CONTENT ---->
                <form action="{{ route('setSessionRoute') }}" id="setSession" method="get">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="input-group mb-3">
                                <input type="text" class="form-control" id="search" placeholder="Código do Client"
                                    aria-label="Recipient's username" aria-describedby="basic-addon2">
                                <span class="input-group-text" id="basic-addon2">012457</span>
                            </div>

                            <div class="col-12">
                                <select class="form-select d-none" multiple id="result">
                                </select>
                            </div>

                            <input type="hidden" name="user" class="form-control" id="id">
                            <input type="hidden" id="name" name="name" class="form-control">

                            <div class="d-grid gap-2 d-none" id="btnFinalizar">
                                <button class="btn btn-success" type="submit">Inserir Rota <i
                                        class="bi bi-signpost-2"></i></button>
                            </div>

                            <div class="col-12">
                                <ol>
                                    @if ($pedidos)
                                        @foreach ($pedidos as $pedido)
                                            <li class="p-3 mb-2 bg-warning text-dark text-decoration-none">
                                                {{ isset($pedido['nome']) ? $pedido['nome'] : '' }}&nbsp;<a
                                                    href="{{ route('deleteSessionRoute', ['id' => $pedido['codigo']]) }}"
                                                    class="">Tirar da Rota <i
                                                        class="bi bi-dash-circle-dotted"></i></a></li>
                                        @endforeach
                                    @endif

                                </ol>

                                <button type="button" class="btn btn-success" id="modalbutton" data-bs-toggle="modal"
                                    data-bs-target="#exampleModal">Selecionar Motorista <i class="bi bi-pin-map"></i></button>

                                <a href="{{ route('allRotas') }}"><button type="button" class="btn btn-info">Ver Rotas <i
                                            class="bi bi-binoculars"></i></button></a>
                            </div>


                        </div>
                    </div>
                </form>
        </section>

        <script src="js/jquery.min.js"></script>
        <script src="js/popper.js"></script>
        <script src="js/bootstrap.min.js"></script>
        <script src="js/main.js"></script>

        <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.js"></script>
        <link href="https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.11.4/jquery-ui.css" rel="stylesheet" />
        <link href="https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.11.4/jquery-ui.theme.css" rel="stylesheet" />
        <script src="https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.11.4/jquery-ui.js"></script>

        <script>
            // TOKEN DE ASSINATURA
            let _token = $('meta[name="csrf-token"]').attr('content');

            /**
             * FUNCAO QUE PEGA VALOR DIGITADO NO INPUT
             */

            $("#search").keyup(function() {

                var name = $("#search").val();

                console.log(name);
                $.ajax({
                    url: "/getAllDataOrderClientById",
                    type: "GET",
                    data: {
                        name: name,
                    },
                    success: function(response) {
                        console.log(response);
                        if (response) {
                            $('#result').removeClass('d-none');

                            // CONVERT ARRAY IN JSON FOR EACH FUNCTION
                            var json = $.parseJSON(response.dados);

                            // SHOW ALL RESULT QUERY
                            var index = [];
                            $.each(json, function(i, item) {
                                index[i] = '<option value=' + item.id + '>' + item
                                    .name + '</option>';
                            });

                            var arr = jQuery.makeArray(index);
                            arr.reverse();
                            $("#result").html(arr);

                            $("select").change(function() {

                                $('#id').val($(this).children("option:selected").val());
                                $('#name').val($(this).children("option:selected").text());
                                var number = $('#id').val();
                                if (number > 0) {
                                    $("#btnFinalizar").removeClass('d-none');
                                    $('#name,#id').addClass('p-3 mb-2 bg-warning text-dark');
                                }
                            });

                        }
                    },
                    error: function(error) {
                        $('#result').html('<option> Produto Digitado Não Existe! </option>');
                    }
                });
            });
        </script>
    </div>
@endsection
