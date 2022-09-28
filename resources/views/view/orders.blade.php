@extends('view.layout')
@section('content')
    <meta name="csrf-token" content="{{ csrf_token() }}" />
    <div class="container">
        <section class="ftco-section">
            <div class="container">
                <div class="row justify-content-center">
                    <div class="col-md-6 text-center mb-4">
                        <h2 class="heading-section">Pedidos <svg xmlns="http://www.w3.org/2000/svg" width="64"
                                height="64" fill="currentColor" class="bi bi-box-seam-fill" viewBox="0 0 16 16">
                                <path fill-rule="evenodd"
                                    d="M15.528 2.973a.75.75 0 0 1 .472.696v8.662a.75.75 0 0 1-.472.696l-7.25 2.9a.75.75 0 0 1-.557 0l-7.25-2.9A.75.75 0 0 1 0 12.331V3.669a.75.75 0 0 1 .471-.696L7.443.184l.01-.003.268-.108a.75.75 0 0 1 .558 0l.269.108.01.003 6.97 2.789ZM10.404 2 4.25 4.461 1.846 3.5 1 3.839v.4l6.5 2.6v7.922l.5.2.5-.2V6.84l6.5-2.6v-.4l-.846-.339L8 5.961 5.596 5l6.154-2.461L10.404 2Z" />
                            </svg></h2>
                    </div>
                </div>

                <!-- BARRA DE PESQUISA -->
                <form method="get">
                    <div class="container">
                        <div class="col-md-4">
                            <label for="pesquisar" class="float-start">Pesquisar: <i class="bi bi-search"></i> </label>
                            <input type="text" placeholder="Digite o Número do Pedido" class="form-control"
                                name="pesquisar" id="pesquisar">
                        </div>
                    </div>
                </form>
                <!--- FINAL --->

                <!-- Button trigger modal -->
                <input type="hidden" id="modalbutton" class="btn btn-primary" data-bs-toggle="modal"
                    data-bs-target="#exampleModal">

                <!-- Button trigger modal -->
                <input type="hidden" id="pagamentoBotao" class="btn btn-primary" data-bs-toggle="modal"
                    data-bs-target="#PagamentoModal">

                <!-- Modal -->
                <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel"
                    aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title text-dark" id="exampleModalLabel">Gerador de Etiquetas <i
                                        class="bi bi-bookmarks"></i>
                                </h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal"
                                    aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                <p class="text-dark">Informações do Pedido</p>

                                <form action="{{ route('getetiqueta') }}" method="get">
                                    <div class="col-md-12">
                                        <label for="orcamento" class="mt-2 text-dark">Orçamento</label>
                                        <input type="text" class="form-control" name="orcamento" id="orcamento">
                                    </div>

                                    <div class="col-md-12">
                                        <label for="exampleFormControlTextarea1" class="mt-2 text-dark">Observações do
                                            Pedido</label>
                                        <textarea class="form-control text-dark" name="observacao" id="exampleFormControlTextarea1" rows="3"></textarea>
                                    </div>

                                    <div class="col-md-6">
                                        <label for="validationCustom02" class="form-label text-dark">Quantidade de
                                            Volumes</label>
                                        <input type="number" size="2" name="volumes" class="form-control "
                                            id="validationCustom02" value="Mark" required>
                                    </div>
                                    <div class="modal-footer">
                                        <input type="submit" class="btn btn-primary"
                                            data-bs-dismiss="modal">Gerar..</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
                <!--- FINAL MODAL --->

                <!-- Modal -->
                <div class="modal fade" id="PagamentoModal" tabindex="-1" aria-labelledby="exampleModalLabel"
                    aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title text-dark" id="exampleModalLabel">Forma de Pagamento <i
                                        class="bi bi-bookmarks"></i>
                                </h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal"
                                    aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                <p class="text-dark">Selecione a Forma de Pagamento <i class="bi bi-cash-coin"></i></p>

                                <form action="{{ route('updatepaymentform') }}" method="post">
                                    @csrf
                                    @method('PUT')
                                    <div class="spinner-border text-primary" role="status">
                                        <span class="visually-hidden">Loading...</span>
                                    </div>
                                    <div class="col-md-4">
                                        <label for="OrcNum" class="mt-2 text-dark">Orçamento</label>
                                        <input type="text" class="form-control" name="OrcNum" id="OrcNum">
                                    </div>

                                    <select class="form-select mt-3" id="colaboradorSelect"
                                        aria-label="Default select example" name="PaymentForm" required>
                                        <option value="" selected>Selecione...</option>
                                        <option value="Dinheiro">Dinheiro <i class="bi bi-cash-coin"></i></option>
                                        <option value="Cartão">Cartão<i class="bi bi-card-heading"></i></option>
                                        <option value="Cheque">Cheque<i class="bi bi-cc-square"></i></option>
                                        <option value="aprazo">Crediário<i class="bi bi-clipboard-plus"></i></option>
                                        <option value="Pix">Pix<i class="bi bi-clipboard-plus"></i></option>
                                        <option value="Boleto">Boleto<i class="bi bi-clipboard-plus"></i></option>
                                    </select>

                                    <div class="modal-footer">
                                        <input type="submit" class="btn btn-primary"
                                            data-bs-dismiss="modal">Gerar..</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
                <!--- FINAL MODAL --->

                <div class="row">
                    <div class="col-md-12">
                        <div class="table-wrap">
                            <table class="table myaccordion table-hover" style="padding: 50px;" id="accordion">
                                <thead>
                                    <tr>
                                        <th>Orçamento</th>
                                        <th>Cliente</th>
                                        <th>Cidade</th>
                                        <th>Quantidade Items</th>
                                        <th>Total</th>
                                        <th>&nbsp;</th>
                                        <th>Imprimir</th>
                                        <th>Status</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($orders as $order)
                                        @if ($order->flag_finalizado == '1')
                                            <tr class="line alert alert-success">
                                                <th scope="row"><input class="orcnum" name="orcnum" type="text"
                                                        size="7" value="{{ $order->ORCNUM }}"></th>
                                                <td> {{ $order->name }}</td>
                                                <td>{{ $order->cidade }}</td>
                                                <td>{{ $order->quantity_items }}</td>
                                                <td>R${{ $order->value }}</td>
                                                <td>
                                                    <i class="fa" aria-hidden="false"></i>
                                                </td>
                                                <td class="botaoImprimir">
                                                    <a class="d-grid gap-2" id="btnFinalizar"><i
                                                            class="bi bi-printer"></i></a>
                                                </td>
                                                <!--- SELECT STATUS DOS PEDIDOS ---->
                                                <td>
                                                    <select class="form-select" id="StatusSelect"
                                                        aria-label="Default select example">
                                                        <option value="{{ $order->id }}" selected>Finalizado</option>
                                                        @foreach ($status as $code)
                                                            <option value="{{ $code->id }}">{{ $code->name }}
                                                            </option>
                                                        @endforeach
                                                    </select>
                                                </td>
                                            </tr>
                                            <!----- LINHA PEDIDO AGUARDANDO ---->
                                        @elseif($order->flag_aguardando == '2')
                                            <tr class="line alert alert-warning">
                                                <th scope="row"><input class="orcnum" name="orcnum" type="text"
                                                        size="7" value="{{ $order->ORCNUM }}"></th>
                                                <td> {{ $order->name }}</td>
                                                <td>{{ $order->cidade }}</td>
                                                <td>{{ $order->quantity_items }}</td>
                                                <td>R${{ $order->value }}</td>
                                                <td>
                                                    <i class="fa" aria-hidden="false"></i>
                                                </td>
                                                <td class="botaoImprimir">
                                                    <a class="d-grid gap-2" id="btnFinalizar"><i
                                                            class="bi bi-printer"></i></a>
                                                </td>
                                                <!--- SELECT STATUS DOS PEDIDOS ---->
                                                <td>
                                                    <select class="form-select" id="StatusSelect"
                                                        aria-label="Default select example">
                                                        <option value="{{ $order->id }}" selected>Aguardando</option>
                                                        @foreach ($status as $code)
                                                            <option value="{{ $code->id }}">{{ $code->name }}
                                                            </option>
                                                        @endforeach
                                                    </select>
                                                </td>
                                            </tr>
                                        @elseif($order->flag_cancelado == '3')
                                            <!----- LINHA PEDIDO CANCELADO ---->
                                            <tr class="line alert alert-danger">
                                                <th scope="row"><input class="orcnum" name="orcnum" type="text"
                                                        size="7" value="{{ $order->ORCNUM }}"></th>
                                                <td> {{ $order->name }}</td>
                                                <td>{{ $order->cidade }}</td>
                                                <td>{{ $order->quantity_items }}</td>
                                                <td>R${{ $order->value }}</td>
                                                <td>
                                                    <i class="fa" aria-hidden="false"></i>
                                                </td>
                                                <td class="botaoImprimir">
                                                    <a class="d-grid gap-2" id="btnFinalizar"><i
                                                            class="bi bi-printer"></i></a>
                                                </td>
                                                <!--- SELECT STATUS DOS PEDIDOS ---->
                                                <td>
                                                    <select class="form-select" id="StatusSelect"
                                                        aria-label="Default select example">
                                                        <option value="{{ $order->id }}" selected>Cancelado</option>
                                                        @foreach ($status as $code)
                                                            <option value="{{ $code->id }}">{{ $code->name }}
                                                            </option>
                                                        @endforeach
                                                    </select>
                                                </td>
                                            </tr>
                                        @endif
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <div class="d-flex" style="padding: 20px;">
            {!! $orders->links() !!}
        </div>

        <script src="js/jquery.min.js"></script>
        <script src="js/popper.js"></script>
        <script src="js/bootstrap.min.js"></script>
        <script src="js/main.js"></script>

        <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.js"></script>
        <link href="https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.11.4/jquery-ui.css" rel="stylesheet" />
        <link href="https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.11.4/jquery-ui.theme.css" rel="stylesheet" />
        <script src="https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.11.4/jquery-ui.js"></script>

        <script>
            // ABRE O MODAL E MOSTRA O FORM
            // PEGA O VALOR DO ORÇAMENTO DENTRO DO TABLE
            const orcamento = $('.orcnum');

            $(".botaoImprimir").each(function(item, i) {
                $(this).click(function() {

                    // VARIAVEL RECEBE O VALOR DO INPUT COM O NUM DO ORÇAMENTO
                    const ORCNUM = $(orcamento[item]).val();
                    // INPUT O VALOR DO ORÇAMENTO NO MODAL
                    $('#orcamento').val(ORCNUM);
                    // SHOW MODAL
                    $('#modalbutton').trigger('click');
                });
            });

            // TOKEN DE ASSINATURA
            let _token = $('meta[name="csrf-token"]').attr('content');

            $('select#StatusSelect').each(function(item, i) {
                $(i).change(function() {
                    const ORCNUM = $(orcamento[item]).val();
                    const STATUS = $(i).val();
                    console.log(i);
                    try {
                        $.ajax({
                            url: "/ChangeStatusOrder",
                            type: "POST",
                            data: {
                                orcnum: ORCNUM,
                                status: STATUS,
                                _token: _token,
                            },
                            beforeSend: function() {
                                $("#loaderDiv").show();
                            },
                            success: function(response) {
                                // mostra os dados de retorno
                                $('#OrcNum').val(ORCNUM); // GUARDA O VALOR DO ORÇAMENTO NO MODAL
                                $('#pagamentoBotao').trigger('click');
                                //window.location.reload();
                            },
                            error: function(error) {
                                console.log(error);
                            }
                        });
                    } catch (error) {
                        console.log(error);
                    }

                });
            });
        </script>
    </div>
@endsection
