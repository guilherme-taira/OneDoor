@extends('view.layout')
@section('content')
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

                <!-- Button trigger modal -->
                <input type="hidden" id="modalbutton" class="btn btn-primary" data-bs-toggle="modal"
                    data-bs-target="#exampleModal">

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
                                        <input type="number" size="2" name="volumes" class="form-control " id="validationCustom02"
                                            value="Mark" required>
                                    </div>
                                    <div class="modal-footer">
                                        <input type="submit" class="btn btn-primary" data-bs-dismiss="modal">Gerar..</button>
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
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($orders as $order)
                                        <tr class="line">
                                            <th scope="row"><input class="orcnum" type="text" size="7" value="{{ $order->ORCNUM }}"></th>
                                            <td> {{ $order->name }}</td>
                                            <td>{{ $order->cidade }}</td>
                                            <td>{{ $order->quantity_items }}</td>
                                            <td>R${{ $order->value }}</td>
                                            <td>
                                                <i class="fa" aria-hidden="false"></i>
                                            </td>
                                            <td class="botaoImprimir">
                                                <a class="d-grid gap-2" id="btnFinalizar"><i class="bi bi-printer"></i></a>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td colspan="6" id="collapseThree" class="collapse acc"
                                                data-parent="#accordion">
                                                <p class="alert alert-danger">Lorem ipsum dolor sit amet, consectetur
                                                    adipisicing elit. Porro iste,
                                                    facere
                                                    sunt sequi nostrum ipsa, amet doloremque magnam reiciendis tempore
                                                    sapiente.
                                                    Necessitatibus recusandae harum nam sit perferendis quia inventore
                                                    natus.
                                                </p>
                                            </td>
                                        </tr>
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
            const orcamento = $('.orcnum');

            $(".line").each(function (item,i) {
                $(this).click(function () {

                    // VARIAVEL RECEBE O VALOR DO INPUT COM O NUM DO ORÇAMENTO
                    const ORCNUM = $(orcamento[item]).val();
                    // INPUT O VALOR DO ORÇAMENTO NO MODAL
                    $('#orcamento').val(ORCNUM);
                    // SHOW MODAL
                    $('#modalbutton').trigger('click');
                });
            });

        </script>
    </div>
@endsection
