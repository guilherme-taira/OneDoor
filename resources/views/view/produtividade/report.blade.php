@extends('view.layout')
@section('content')
    <div class="container">
        <section class="ftco-section">
            <div class="container">
                <div class="row justify-content-center">
                    <div class="col-md-6 text-center mb-4">
                        <h2 class="heading-section">Relatórios de Produtividade<div class="mt-4"></div>
                            <div class="mt-4" id="loader"></div>
                        </h2>

                        <div class="container">
                            <form class="row g-3 needs-validation" action="{{route('generateprodutividadereport')}}" method="GET">
                                <div class="col-md-3">
                                    <label for="validationCustom04" class="form-label">Colaborador</label>
                                    <select class="form-select" id="colaboradorSelect" aria-label="Default select example">
                                        <option selected value="">Todos...</option>

                                        @if (count($vendedores) > 0)
                                            @foreach ($vendedores as $vendedor)
                                                <option value="{{ $vendedor->id }}">{{ $vendedor->nome }}</option>
                                            @endforeach
                                        @else
                                            <option value="1">DEFAULT</option>
                                        @endif
                                    </select>
                                    <div class="invalid-feedback">
                                        Please select a valid state.
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <label for="validationCustom02" class="form-label">Data Inicial</label>
                                    <input type="date" class="form-control" name="datainicial" id="validationCustom02" value="Otto"
                                        required>
                                    <div class="valid-feedback">
                                        Looks good!
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <label for="validationCustom02" class="form-label">Data Final</label>
                                    <input type="date" class="form-control" name="datafinal" id="validationCustom02" value="Otto"
                                        required>
                                    <div class="valid-feedback">
                                        Looks good!
                                    </div>
                                </div>

                                <div class="col-12">
                                    <button class="btn btn-primary" type="submit">Gerar Relatório</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
        </section>
    </div>
@endsection
