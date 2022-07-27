@extends('view.layout')
@section('content')
    <div class="container">
        <section class="ftco-section">
            <div class="container">
                <div class="row justify-content-center">
                    <div class="col-md-6 text-center mb-4">
                        <h2 class="heading-section">Editar Pedido <svg xmlns="http://www.w3.org/2000/svg" width="32"
                                height="32" fill="currentColor" class="bi bi-pencil-square" viewBox="0 0 16 16">
                                <path
                                    d="M15.502 1.94a.5.5 0 0 1 0 .706L14.459 3.69l-2-2L13.502.646a.5.5 0 0 1 .707 0l1.293 1.293zm-1.75 2.456-2-2L4.939 9.21a.5.5 0 0 0-.121.196l-.805 2.414a.25.25 0 0 0 .316.316l2.414-.805a.5.5 0 0 0 .196-.12l6.813-6.814z" />
                                <path fill-rule="evenodd"
                                    d="M1 13.5A1.5 1.5 0 0 0 2.5 15h11a1.5 1.5 0 0 0 1.5-1.5v-6a.5.5 0 0 0-1 0v6a.5.5 0 0 1-.5.5h-11a.5.5 0 0 1-.5-.5v-11a.5.5 0 0 1 .5-.5H9a.5.5 0 0 0 0-1H2.5A1.5 1.5 0 0 0 1 2.5v11z" />
                            </svg></h2>
                    </div>
                </div>


                <div class="row">
                    <div class="col-md-12">
                        <div class="container-fluid mx-auto">

                            <ol class="alert alert-danger">
                                @foreach (json_decode($order->response, true) as $value)
                                    @foreach ($value as $val)
                                        @if ($val == 'City may not be blank.')
                                            <li class="erros">A cidade não pode ficar em branco</li>
                                        @elseif ($val == 'Number may not be blank.')
                                            <li class="erros">O número não pode ficar em branco</li>
                                        @elseif ($val == 'State may not be blank.')
                                            <li class="erros">O estado não pode ficar em branco.</li>
                                        @elseif ($val == 'must be a well-formed email address')
                                            <li class="erros">deve ser um endereço de e-mail bem
                                                formado</li>
                                        @elseif ($val == 'The forecast delivery date must be greater than creation date')
                                            <li class="erros">A data de entrega prevista deve ser maior que a data de
                                                criação</li>
                                        @else
                                            {{ $val }}
                                        @endif
                                    @endforeach
                                @endforeach
                            </ol>


                            @if ($errors->any())
                                <div class="alert alert-danger">
                                    <ul>
                                        @foreach ($errors->all() as $error)
                                            <li>{{ $error }}</li>
                                        @endforeach
                                    </ul>
                                </div>
                            @endif

                            <div class="row d-flex justify-content-center">
                                <div class=" text-center">
                                    <div class="card py-4">
                                        <form action="{{ route('orders.update', ['id' => $order->id]) }}" method="POST">
                                            @csrf
                                            @method('PUT')
                                            <input type="hidden" name="clientId" value="{{ $order->id }}">
                                            <div class="row justify-content-between text-left">
                                                <div class="form-group col-sm-6 flex-column d-flex"> <label
                                                        class="form-control-label px-3 text-primary">Cliente<span
                                                            class="text-danger"> *</span></label> <input type="text"
                                                        id="fname" name="fname" placeholder="Enter your first name"
                                                        value="{{ $order->name }}" onblur="validate(1)"> </div>
                                                <div class="form-group col-sm-6 flex-column d-flex"> <label
                                                        class="form-control-label px-3 text-primary">Orçamento<span
                                                            class="text-danger"> *</span></label> <input type="text"
                                                        id="lname" name="orcnum" value="{{ $order->ORCNUM }}"
                                                        placeholder="Orçamento ret" onblur="validate(2)"> </div>
                                            </div>
                                            <div class="row justify-content-between text-left mt-2">
                                                <div class="form-group col-sm-6 flex-column d-flex"> <label
                                                        class="form-control-label px-3 text-primary">email<span
                                                            class="text-danger"> *</span></label> <input type="text"
                                                        id="email" name="email" value="{{ $order->email }}"
                                                        placeholder="digite o email do cliente" onblur="validate(3)"> </div>
                                                <div class="form-group col-sm-6 flex-column d-flex"> <label
                                                        class="form-control-label px-3 text-primary">Telefone<span
                                                            class="text-danger"> *</span></label> <input type="text"
                                                        id="telefone" name="telefone" value="{{ $order->telefone }}"
                                                        placeholder="" onblur="validate(4)"> </div>
                                            </div>
                                            <div class="row justify-content-between text-left mt-2">
                                                <div class="form-group col-sm-6 flex-column d-flex"> <label
                                                        class="form-control-label px-3 text-primary">documento<span
                                                            class="text-danger"> *</span></label> <input type="text"
                                                        id="documento" name="documento" placeholder="digite CPF / CNPJ"
                                                        value="{{ $order->documento }}" onblur="validate(5)"></div>

                                                <div class="form-group col-sm-6 flex-column d-flex"> <label
                                                        class="form-control-label px-3 text-primary">Cidade<span
                                                            class="text-danger"> *</span></label> <input type="text"
                                                        id="cidade" name="cidade" value="{{ $order->cidade }}"
                                                        placeholder="" onblur="validate(4)"> </div>
                                            </div>

                                            <div class="row justify-content-between text-left mt-2">
                                                <div class="form-group col-sm-6 flex-column d-flex"> <label
                                                        class="form-control-label px-3 text-primary">Bairro<span
                                                            class="text-danger"> *</span></label> <input type="text"
                                                        id="bairro" name="bairro" placeholder="digite CPF / CNPJ"
                                                        value="{{ $order->bairro }}" onblur="validate(5)"></div>

                                                <div class="form-group col-sm-6 flex-column d-flex"> <label
                                                        class="form-control-label px-3 text-primary">Número<span
                                                            class="text-danger"> *</span></label> <input type="text"
                                                        id="numero" name="numero" value="{{ $order->numero }}"
                                                        placeholder="" onblur="validate(4)"> </div>
                                            </div>

                                            <div class="row justify-content-between text-left mt-2">
                                                <div class="form-group col-sm-6 flex-column d-flex"> <label
                                                        class="form-control-label px-3 text-primary">Endereço<span
                                                            class="text-danger"> *</span></label> <input type="text"
                                                        id="endereco" name="endereco" placeholder="digite CPF / CNPJ"
                                                        value="{{ $order->endereco }}" onblur="validate(5)"></div>

                                                <div class="form-group col-sm-6 flex-column d-flex"> <label
                                                        class="form-control-label px-3 text-primary">Complemento<span
                                                            class="text-danger"> *</span></label> <input type="text"
                                                        id="complemento" name="complemento"
                                                        value="{{ $order->complemento }}" placeholder=""
                                                        onblur="validate(4)"> </div>
                                            </div>

                                            <div class="row justify-content-between text-left mt-2">
                                                <div class="form-group col-sm-6 flex-column d-flex"> <label
                                                        class="form-control-label px-3 text-primary">Valor da Venda<span
                                                            class="text-danger"> *</span></label> <input type="text"
                                                        id="valor" name="valor" placeholder="digite CPF / CNPJ"
                                                        value="{{ $order->value }}" onblur="validate(5)"></div>

                                                <div class="form-group col-sm-6 flex-column d-flex"> <label
                                                        class="form-control-label px-3 text-primary">Hora da Venda<span
                                                            class="text-danger"> *</span></label> <input type="text"
                                                        id="horavenda" name="horavenda" value="{{ $order->HORASAIDA }}"
                                                        placeholder="" onblur="validate(4)"> </div>
                                            </div>

                                            <div class="row justify-content-between text-left mt-2">
                                                <div class="form-group col-sm-6 flex-column d-flex"> <label
                                                        class="form-control-label px-3 text-primary">UF<span
                                                            class="text-danger"> *</span></label> <input type="text"
                                                        id="uf" name="uf" placeholder="digite CPF / CNPJ"
                                                        value="{{ $order->UF }}" onblur="validate(5)"></div>

                                                <div class="form-group col-sm-6 flex-column d-flex"> <label
                                                        class="form-control-label px-3 text-primary">Quantidade de
                                                        Items<span class="text-danger"> *</span></label> <input
                                                        type="text" id="qtditems" name="qtditems"
                                                        value="{{ $order->quantity_items }}" placeholder=""
                                                        onblur="validate(4)"> </div>
                                            </div>

                                            <div class="row justify-content-between text-left mt-2">
                                                <div class="form-group col-sm-6 flex-column d-flex"> <label
                                                        class="form-control-label px-3 text-primary">Data Criação<span
                                                            class="text-danger"> *</span></label> <input type="text"
                                                        id="forecast" name="forecast" placeholder="digite CPF / CNPJ"
                                                        value="{{ $order->created_at }}" onblur="validate(5)"></div>
                                            </div>

                                            <div class="row">
                                                <div class="form-group col-sm-1 mt-2"> <input type="submit"
                                                        class="btn-block btn-primary" value="Salvar Pedido"> </div>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
    </div>
    </section>

    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.0.3/css/font-awesome.css"></script>
    </div>
@endsection
