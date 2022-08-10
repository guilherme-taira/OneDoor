@extends('view.layout')
@section('content')
    <div class="container">
        <section class="ftco-section">
            <div class="container">
                <div class="row justify-content-center">
                    <div class="col-md-6 text-center mb-4">
                        <h2 class="heading-section">Colaboradores - Produtividade Dia: {{date('Y/m/d')}}<div class="mt-4"></div>
                            <div class="mt-4" id="loader"></div>
                        </h2>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12">
                        <div class="table-wrap">
                            <table class="table myaccordion table-hover" style="padding: 50px;" id="accordion">
                                <thead>
                                    <tr class='text-center fs-1'>
                                        <th>Colaborador</th>
                                        <th>Quantidade</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($produtividades as $produtividade)
                                        <tr>
                                            <th class='text-center fs-1' scope="row">{{ $produtividade->nome }}</th>
                                            <td class='text-center fs-1'><span class="badge bg-primary">{{ $produtividade->quantidade }}</span></td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
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
