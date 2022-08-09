@extends('view.layout')
@section('content')
    <div class="container">
        <section class="ftco-section">
            <div class="container">
                <div class="row justify-content-center">
                    <div class="col-md-6 text-center mb-4">
                        <h2 class="heading-section" id="loader">Cadastro Manual </h2>
                    </div>
                </div>
                <div class="row" id="content-form">
                    <form action="" method="get">
                        <div class="row mt-2">
                            <h6>Parte de Cima:</h6>
                            <input placeholder="codigo de barras..." required class="form-control mt-2" autofocus
                                name="cima" id="cima">
                        </div>

                        <div class="row mt-2">
                            <h6>Parte de Baixo:</h6>
                            <input placeholder="codigo de barras..." required class="form-control mt-2" name="baixo"
                                id="baixo">
                        </div>

                        <div class="row mt-2">
                            <input type="submit" class="btn btn-primary mt-2" value="Pesquisar">
                        </div>
                    </form>
                </div>

                <div class="row d-none" id="content-complete">
                    <div class="row mt-2">
                        <h6>Cupom Fiscal:</h6>
                        <input placeholder="codigo de barras..." required class="form-control mt-2" name="completo"
                            id="completo">
                    </div>

                    <div class="row mt-2">
                        <input type="submit" class="btn btn-primary mt-2" id="buscaBando" value="Cadastrar">
                    </div>

                    <div class="row-2">
                        <button class="btn btn-warning mt-2 float-end" type="button" id="loaderDiv" disabled>
                            <span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>
                            Loading...
                        </button>
                    </div>
                </div>

                <div class="returnResponse">
                    <div class="container">
                        <section class="ftco-section">
                            <div class="container">
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="table-wrap">
                                            <table class="table myaccordion table-hover" style="padding: 50px;"
                                                id="accordion">
                                                <thead>
                                                    <tr>
                                                        <th>Cliente</th>
                                                        <th>Data</th>
                                                        <th>SAT Chave</th>
                                                        <th>Terminal</th>
                                                        <th>Vendendor</th>
                                                        <th>Orçamento</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <tr>
                                                        <th scope="row" id="cliente"></th>
                                                        <td id="data"></td>
                                                        <td id="sat_chave"></td>
                                                        <td id="terminal"></td>
                                                        <td id="vendedor"></td>
                                                        <td id="orcamento"></td>
                                                    </tr>
                                                </tbody>
                                            </table>

                                            <div class="row mt-2">
                                                <div id="msg"></div>
                                            </div>

                                        </div>
                                    </div>
                                </div>
                            </div>
                        </section>
                    </div>
                </div>
            </div>
        </section>
    @endsection


    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.js"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.11.4/jquery-ui.css" rel="stylesheet" />
    <link href="https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.11.4/jquery-ui.theme.css" rel="stylesheet" />
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.11.4/jquery-ui.js"></script>

    <script>
        $(document).ready(function() {
            $("#loaderDiv").hide();
            $('.returnResponse').hide();
            $('#msg').hide();

            $('#cima').change(function() {
                const valorCima = $('#cima').val();
                return valorCima;
            });

            $('#baixo').change(function() {
                const valorBaixo = $('#baixo').val();
            });


            $('form').submit(function(event) {
                event.preventDefault();
                $('#content-form').addClass('d-none');
                $('#content-complete').removeClass('d-none');
                $('#completo').val('CFe' + $('#cima').val() + $('#baixo').val());
                console.log($('#completo').val());
            });


            // BUSCA A CHAVE NO BANCO
            $('#buscaBando').on('click', function() {

                const code = $('#completo').val();

                const res = $.ajax({
                    url: "/getInformationOrder",
                    type: "GET",
                    data: {
                        code: code,
                    },
                    success: function(response) {
                        // mostra o retorno dos dados
                        $('.returnResponse').show();
                        $('#content-complete').addClass('d-none');

                        try {
                            var json = $.parseJSON(response.dados);
                            $("#cliente").append(json[0].CLINome);
                            $("#data").append(json[0].SAIData);
                            $("#sat_chave").append(json[0].SATCHAVE);
                            $("#terminal").append(json[0].SAITERMINAL);
                            $("#vendedor").append(json[0].VENDCOD);
                            $("#orcamento").append(json[0].SAICupom);

                            $.ajax({
                                url: "/storeNewOrcamento",
                                type: "GET",
                                data: {
                                    ORCAMENTO: json[0].SAICupom,
                                    DATA: json[0].SAIData,
                                    SAT_CHAVE: json[0].SATCHAVE,
                                    VENDEDOR: json[0].VENDCOD,
                                    PDV: json[0].SAITERMINAL,
                                },
                                beforeSend: function() {
                                    $("#loaderDiv").show();
                                },
                                success: function(response) {
                                    // mostra os dados de retorno
                                    $("#loaderDiv").slideUp('slow');
                                    $('#msg').show();
                                    console.log(response);
                                    if(res.status == '200'){
                                        $('#msg').addClass('alert alert-warning').append(response.response);
                                    }else if(res.status == '201'){
                                        $('#msg').addClass('alert alert-success').append(response.response);
                                    }
                                },
                                error: function(error) {
                                    console.log(error);
                                }
                            });

                        } catch (error) {
                            console.log(error);
                        }
                    },
                    error: function(error) {
                        console.log(error);
                    }
                });
            });








            // $('#cadastrar').on('click', function() {
            //     $.ajax({
            //         url: "/storeNewOrcamento",
            //         type: "GET",
            //         data: {
            //             code: code,
            //         },
            //         beforeSend: function() {
            //             $("#loaderDiv").show();
            //         },
            //         success: function(response) {

            //             $("#loaderDiv").slideUp('slow');
            //             // mostra o retorno dos dados
            //             $('.returnResponse').show();
            //             $('#content-complete').addClass('d-none');

            //             try {
            //                 var json = $.parseJSON(response.dados);
            //                 $("#cliente").append(json[0].CLINome);
            //                 $("#data").append(json[0].SAIData);
            //                 $("#sat_chave").append(json[0].SATCHAVE);
            //                 $("#terminal").append(json[0].SAITERMINAL);
            //                 $("#vendedor").append(json[0].SAIUSUARIO);
            //                 $("#orcamento").append(json[0].ORCNUM);
            //             } catch (error) {

            //             }

            //         },
            //         error: function(error) {
            //             console.log(error);
            //         }
            //     });
            // });

        });
    </script>
