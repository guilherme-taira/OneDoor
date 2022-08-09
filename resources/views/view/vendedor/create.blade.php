@extends('view.layout')
@section('content')
    <div class="container">
        <section class="ftco-section">
            <div class="container">
                <div class="row justify-content-center">
                    <div class="col-md-6 text-center mb-4">
                        <h2 class="heading-section">Colaboradores - Expedição<div class="mt-4"></div>
                        </h2>
                    </div>
                </div>
                <div class="row">

                    <div class="col-md-2">
                        <a href="{{ route('vendedor.create') }}" class="btn btn-success">Novo Usuário <i
                                class="bi bi-person-plus-fill"></i></a>
                    </div>

                    <div class="col-md-12">
                        <div class="card">
                            <div class="card-header bg-primary">
                                Cadastro de Novo Colaborador
                            </div>
                            <div class="card-body">
                                <h5 class="card-title text-primary">Novo Colaborador</h5>
                                <form action="{{ route('vendedor.store') }}" method="post">

                                    @csrf
                                    <div class="mb-3">
                                        <label for="formGroupExampleInput" class="form-label">Nome do Colaborador</label>
                                        <input type="text" class="form-control" name="nome" id="formGroupExampleInput"
                                            placeholder="Digite o nome do colaborador" required>
                                    </div>
                                    <div class="mb-3">
                                        <input type="submit" value="Cadastrar" class="btn btn-primary">
                                    </div>
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
