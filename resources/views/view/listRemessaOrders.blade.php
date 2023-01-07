@extends('view.layout')
@section('content')
    <meta name="csrf-token" content="{{ csrf_token() }}" />
    <div class="container">
        <section class="ftco-section">
            <div class="container">
                <div class="row justify-content-center">
                    <div class="col-md-6 text-center mb-4">
                        <h2 class="heading-section">Todas os Pedidos <svg xmlns="http://www.w3.org/2000/svg" width="64"
                                height="64" fill="currentColor" class="bi bi-box-seam-fill" viewBox="0 0 16 16">
                                <path fill-rule="evenodd"
                                    d="M15.528 2.973a.75.75 0 0 1 .472.696v8.662a.75.75 0 0 1-.472.696l-7.25 2.9a.75.75 0 0 1-.557 0l-7.25-2.9A.75.75 0 0 1 0 12.331V3.669a.75.75 0 0 1 .471-.696L7.443.184l.01-.003.268-.108a.75.75 0 0 1 .558 0l.269.108.01.003 6.97 2.789ZM10.404 2 4.25 4.461 1.846 3.5 1 3.839v.4l6.5 2.6v7.922l.5.2.5-.2V6.84l6.5-2.6v-.4l-.846-.339L8 5.961 5.596 5l6.154-2.461L10.404 2Z" />
                            </svg></h2>
                    </div>
                </div>

                <!---- CONTENT ---->
                <div class="row">
                    <div class="col-md-6">
                        <p> <strong>* O tempo Médio precisa ser divido pela quantidade de pedidos na remessa! </strong></p>
                    </div>
                    <table class="table table-dark table-striped">
                        <thead>
                            <tr>
                                <th scope="col">Codigo Cliente</th>
                                <th scope="col">Nome</th>
                                <th scope="col">Cadastrado</th>
                                <th scope="col">Finalizado</th>
                                <th scope="col">Remessa</th>
                                <th scope="col">Tempo Médio</th>
                            </tr>
                        </thead>

                        @foreach ($remessas as $remessa)
                            <tr>
                                <td>{{ $remessa->codcli }}</td>
                                <td>{{ $remessa->name }}</td>
                                <td>{{ $remessa->dateStart }}</td>
                                <td>{{ $remessa->dateFinished }}</td>
                                <td>{{ $remessa->remessa }}</td>
                                <td>{{ $remessa->tempoMedio }}</td>
                            </tr>
                        @endforeach

                        </tbody>
                    </table>

                </div>
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
