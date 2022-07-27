@extends('view.layout')
@section('content')
    <div class="container">
        <section class="ftco-section">
            <div class="container">
                <div class="row justify-content-center">
                    <div class="col-md-6 text-center mb-4">
                        <h2 class="heading-section" id="loader">Consulta de Produtos </h2>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12">
                        <div class="table-wrap">
                            <!-- CONTENT -->
                            <form>
                                <div class="col-md-12">
                                    <h6>Codigo de Barras</h6>
                                    <p>
                                        <input placeholder="codigo de barras..." oninput="this.className = ''"
                                            id="sku" name="sku">
                                    </p>
                                </div>

                                <div class="col-md-12">
                                    <h6>Nome:</h6>
                                    <p>
                                        <input placeholder="codigo de barras..." oninput="this.className = ''"
                                            name="name" id="name">
                                    </p>
                                </div>

                                <button type="submit"class="btn btn-primary">Pesquisar</button>
                            </form>
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

        $('form').submit(function(event) {
            event.preventDefault();
            alert('Submitou');
        });



        $("#name").keyup(function() {
            var name = $("#name").val();
            $.ajax({
                url: "/consultaret",
                type: "GET",
                data: {
                    name: name,
                },
                success: function(response) {
                    console.log(response);
                    if (response) {
                        //$('#result').removeClass('d-none');

                        // CONVERT ARRAY IN JSON FOR EACH FUNCTION
                        //var json = $.parseJSON(response.dados);
                        console.log(response);
                        // SHOW ALL RESULT QUERY
                        // var index = [];
                        // $.each(json, function(i, item) {
                        //     index[i] = '<option value=' + item.id + '>' + item
                        //         .name + '</option>';
                        // });

                        // var arr = jQuery.makeArray(index);
                        // arr.reverse();
                        // $("#result").html(arr);

                        // $("select").change(function() {
                        //     $('#id').val($(this).children("option:selected")
                        //         .val());
                        //     $('#name').val($(this).children("option:selected")
                        //         .text());
                        //     var number = $('#id').val();
                        //     if (number > 0) {
                        //         $("#btnFinalizar").removeClass('d-none');
                        //         $('#name,#id').addClass(
                        //             'p-3 mb-2 bg-warning text-dark');
                        //     }

                        // });

                    }
                },
                error: function(error) {
                    $('#result').html('<option> Produto Digitado Não Existe! </option>');
                }
            });
        });
    });
</script>
