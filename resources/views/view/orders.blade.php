@extends('view.layout')
@section('content')
    <div class="container">
        <section class="ftco-section">
            <div class="container">
                <div class="row justify-content-center">
                    <div class="col-md-6 text-center mb-4">
                        <h2 class="heading-section">Pedidos <svg xmlns="http://www.w3.org/2000/svg"
                                width="64" height="64" fill="currentColor" class="bi bi-box-seam-fill"
                                viewBox="0 0 16 16">
                                <path fill-rule="evenodd"
                                    d="M15.528 2.973a.75.75 0 0 1 .472.696v8.662a.75.75 0 0 1-.472.696l-7.25 2.9a.75.75 0 0 1-.557 0l-7.25-2.9A.75.75 0 0 1 0 12.331V3.669a.75.75 0 0 1 .471-.696L7.443.184l.01-.003.268-.108a.75.75 0 0 1 .558 0l.269.108.01.003 6.97 2.789ZM10.404 2 4.25 4.461 1.846 3.5 1 3.839v.4l6.5 2.6v7.922l.5.2.5-.2V6.84l6.5-2.6v-.4l-.846-.339L8 5.961 5.596 5l6.154-2.461L10.404 2Z" />
                            </svg></h2>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12">
                        <div class="table-wrap">
                            <table class="table myaccordion table-hover" style="padding: 50px;" id="accordion">
                                <thead>
                                    <tr>
                                        <th>Orçamento</th>
                                        <th>Cliente</th>
                                        <th>Código Cliente</th>
                                        <th>Cidade</th>
                                        <th>Quantidade Items</th>
                                        <th>Total</th>
                                        <th>&nbsp;</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($orders as $order)
                                        <tr>
                                            <th scope="row">{{ $order->ORCNUM }}</th>
                                            <td>{{ $order->name }}</td>
                                            <td>{{ $order->client_id }}</td>
                                            <td>{{ $order->cidade }}</td>
                                            <td>{{ $order->quantity_items }}</td>
                                            <td>R${{ $order->value }}</td>
                                            <td>
                                                <i class="fa" aria-hidden="false"></i>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td colspan="6" id="collapseThree" class="collapse acc"
                                                data-parent="#accordion">
                                                <p class="alert alert-danger">Lorem ipsum dolor sit amet, consectetur adipisicing elit. Porro iste,
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
    </div>
@endsection
