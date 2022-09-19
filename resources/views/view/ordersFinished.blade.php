@extends('view.layout')
@section('content')
    <div class="container">
        <section class="ftco-section">
            <div class="container">
                <div class="row justify-content-center">
                    <div class="col-md-6 text-center mb-4">
                        <h2 class="heading-section">Relatório de Vendas</h2>
                    </div>
                </div>

                <!---- FORM RELATORIO ----->
                <form action="{{route('formFinishedOrder')}}"  method="get">
                    @csrf
                <div class="row">
                    <div class="col-md-12">
                        <div class="container">
                            <div class="row">
                                <div class="col-2">
                                    <!-- CAIXA SELECT -->
                                    <div class="form-outline">
                                        <select class="form-select" name="caixa" required class="form-control"
                                            aria-label="Default select example">
                                            <option value="">Caixa</option>
                                            <option value="10">10</option>
                                            <option value="11">11</option>
                                            <option value="13">13</option>
                                        </select>
                                        <label class="form-label" for="form8Example1">Caixa</label>
                                    </div>
                                </div>
                                <div class="col">
                                    <!-- DATA INICIAL input -->
                                    <div class="form-outline">
                                        <input type="date" id="form8Example2" name="datainicial" class="form-control" />
                                        <label class="form-label" for="form8Example2">Data Inicial</label>
                                    </div>
                                </div>

                                <div class="col">
                                    <!-- DATA FINAL input -->
                                    <div class="form-outline">
                                        <input type="date" id="form8Example2" name="datafinal" class="form-control" />
                                        <label class="form-label" for="form8Example2">Data Final</label>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="form-outline col-4">
                                    <label class="form-label" for="form8Example1">Status da Venda</label>
                                    <select class="form-select" name="status" required class="form-control"
                                        aria-label="Default select example">
                                        <option selected>...</option>
                                        <option value="1">Finalizado</option>
                                        <option value="2">Aguardando</option>
                                        <option value="3">Cancelado</option>
                                    </select>
                                </div>
                            </div>
                            <hr>
                            <div class="form-outline col-12">
                                <input type="submit" value="Gerar Relatório" class="btn btn-success">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </form>
        </section>
    </div>
@endsection
