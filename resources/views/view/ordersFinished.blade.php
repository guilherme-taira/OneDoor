@extends('view.layout')
@section('content')
    <div class="container">
        <section class="ftco-section">
            <div class="container">
                <div class="row justify-content-center">
                    <div class="col-md-6 text-center mb-4">
                        <h2 class="heading-section">Pedidos Finalizados</h2>
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
