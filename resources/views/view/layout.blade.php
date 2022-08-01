<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
        <meta name="description" content="" />
        <meta name="author" content="" />
        <title>Integração Onedoor Embaleme</title>
        <link rel="icon" type="image/x-icon" href="assets/favicon.ico" />
        <script src="{{asset('js/app.js')}}"></script>
        <!-- Font Awesome icons (free version)-->
        <script src="https://use.fontawesome.com/releases/v6.1.0/js/all.js" crossorigin="anonymous"></script>
        <!-- Google fonts-->
        <link href="https://fonts.googleapis.com/css?family=Catamaran:100,200,300,400,500,600,700,800,900" rel="stylesheet" />
        <link href="https://fonts.googleapis.com/css?family=Lato:100,100i,300,300i,400,400i,700,700i,900,900i" rel="stylesheet" />
        <!-- Core theme CSS (includes Bootstrap)-->
        <link href="{{asset('css/styles.css')}}" rel="stylesheet" />
        <link href="{{asset('css/app.css')}}" rel="stylesheet" />
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.9.1/font/bootstrap-icons.css">
    </head>
    <body id="page-top">
        <!-- Navigation-->
        <nav class="navbar navbar-expand-lg navbar-dark navbar-custom fixed-top">
            <div class="container px-5">
                <a class="navbar-brand" href="{{route('home')}}"> <i class="bi bi-door-open"></i> OneDoor <-> Embaleme </a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarResponsive" aria-controls="navbarResponsive" aria-expanded="false" aria-label="Toggle navigation"><span class="navbar-toggler-icon"></span></button>
                <div class="collapse navbar-collapse" id="navbarResponsive">
                    <ul class="navbar-nav ms-auto">
                        <li class="nav-item"><a class="nav-link" href="{{route('ordersFail')}}">Pedidos com Erros <i class="bi bi-asterisk"></i></a></li>
                        <li class="nav-item"><a class="nav-link" href="{{route('orders.index')}}">Pedidos <i class="bi bi-box2-heart"></i></a></li>
                        <li class="nav-item"><a class="nav-link" href="{{route('gravapedidos')}}">Integração <i class="bi bi-arrow-left-right"></i></i></a></li>
                        <li class="nav-item"><a class="nav-link" href="{{route('orders.create')}}">Cadastro Manual<i class="bi bi-arrow-left-right"></i></i></a></li>
                    </ul>
                </div>
            </div>
        </nav>
        <!-- Header-->
        <header class="masthead text-center text-white">
            <section id="scroll">
                {{-- <div class="container">
                    <div class="card" style="width: 18rem;">
                        <div class="card-header bg-primary">
                          PDV LOGADOS
                        </div>
                        <ul class="list-group list-group-flush" id="publico">

                        </ul>
                      </div>
                </div> --}}

                <div class="container px-5">
                    @yield('content')
                </div>
            </section>
        </header>
        <!-- Content section 1-->

        <!-- Footer-->
        <footer class="py-5 bg-black">
            <div class="container px-5"><p class="m-0 text-center text-white small">Copyright &copy; EMBALEME {{date('Y')}}</p></div>
        </footer>
        <!-- Bootstrap core JS-->
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
        <!-- Core theme JS-->
        <script src="js/scripts.js"></script>

        <script>
            var publico = document.getElementById("publico");
            Echo.channel('channel-publico').listen('channelPublico',(e) => {
                publico.innerHTML += "<div class='alert alert-success'>" + e.mensagem + '</div>';
            });
        </script>
         <!-- Option 2: Separate Popper and Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js" integrity="sha384-IQsoLXl5PILFhosVNubq5LC7Qb9DXgDA9i+tQ8Zj3iwWAwPtgFTxbJ8NT4GN1R8p" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.min.js" integrity="sha384-cVKIPhGWiC2Al4u+LWgxfKTRIcfu0JTxR+EQDz/bgldoEyl4H0zUF0QKbrJ0EcQF" crossorigin="anonymous"></script>
    </body>
</html>



