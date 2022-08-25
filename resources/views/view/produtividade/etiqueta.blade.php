<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <!-- MDB -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/mdb-ui-kit/4.2.0/mdb.min.css" rel="stylesheet" />
    <title>Document</title>
    <style>
        p {
            font-weight: bold;
            margin-bottom: 10px;
        }

        .page-break {
            page-break-before: always;
        }
    </style>
</head>

<body>
    @for ($i = 1; $i <= $volumes; $i++)
        @foreach ($dados as $dado)
            <div class="card text-center">
                <div class="card-body">
                    <h2>Pedido: {{ $dado->ORCNUM }}</h2>
                    <p class="card-text"><strong>Embaleme Comércio de Embalagem e Festas</strong></p>
                    <h2 class="card-title"><strong>VOL: {{ $i }} de {{ $volumes }}</strong></h2>
                </div>

                <div class="card">
                    <p>Cliente:</p>
                    <h2>{{ $dado->name }} </h2>
                    @if ($observacao)
                        <hr>
                        <p>Observações: {{ $observacao }}</p>
                    @endif
                    <p>Facebook @embalemefestas, Instagram: @embalemefestas Telefone: (19) 3571-3311</p>
                </div>
            </div>
            @if ($i < $volumes)
                <div class="page-break"></div>
            @endif
        @endforeach
    @endfor
    <!-- MDB -->
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/mdb-ui-kit/4.2.0/mdb.min.js"></script>
</body>

</html>
