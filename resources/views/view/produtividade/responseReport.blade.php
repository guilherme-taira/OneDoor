<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <!-- MDB -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/mdb-ui-kit/4.2.0/mdb.min.css" rel="stylesheet" />
    <title>Document</title>
</head>

<body>
    <div class="card text-center">
        <div class="card-body">
            <h5 class="card-title">Embaleme</h5>
            <p class="card-text">Comércio de Embalagem e Festas</p>
        </div>

        <div class="card">
            <div class="card-header"> Relatório de Produtividade </div>
            <hr>
            <table class="table">
                <thead>
                    <tr>
                        <th></th>
                        <th scope="col">Colaborador</th>
                        <th scope="col">Quantidade</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($dados as $dado)
                        @foreach ($dado as $valor)
                            <tr>
                                <td rowspan = "3">{{ $valor['colaborador'] }}</td>
                                <td rowspan = "3">{{ $valor['Data'] }}</td>
                                <td rowspan = "3">{{ $valor['Quantidade'] }}</td>
                            </tr>
                        @endforeach
                    @endforeach
                </tbody>
            </table>
            <hr>
        </div>
    </div>
    </div>
    <!-- MDB -->
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/mdb-ui-kit/4.2.0/mdb.min.js"></script>
</body>

</html>
