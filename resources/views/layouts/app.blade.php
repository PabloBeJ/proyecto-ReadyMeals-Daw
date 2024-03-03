<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <!--Metas-->
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="title" content="Comidas de Harry Potter">
    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ config('app.name', 'Ready Meals') }}</title>
    <link  rel="icon" type="image/x-icon"   href="../public/img/LogoReadyMeals.jpg">
    <!-- Styles -->
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0/css/materialize.min.css">
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
    <!--   Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>
</head>
<body>
    <div class="navegacion" >
        <!--Logo-->
        <div class="titulo">
            <a href="{{ route('home') }}" class="brand-logo" title="Inicio">
                {{ Html::image('img/LogoReadyMeals.jpg', 'Logo Ready Meals') }}
            </a>
            <h1> <a href="{{ route('home') }}">Ready Meals </a></h1>
        </div>
        <nav>
        <!--Botón menú móviles-->
        <a href="#" data-target="mobile-demo" class="sidenav-trigger fixed-top right"><i class="material-icons right-align">menu</i></a>
        <!--Menú de navegación-->
            <ul id="nav-mobile" class="nav-nomobile right hide-on-med-and-down">
                <li>
                    <a href="{{ route('home') }}" title="Inicio">Inicio</a>
                </li>
                <li>
                    <a href="{{ route('comidas') }}" title="Comidas">Comidas</a>
                </li>
                <li>
                   <div class="input-field  white-text">
                        <i href="#" class="yellow-text material-icons prefix">search</i>
                        <input type="text" style="color:white">
                    </div>
                @if( Auth::check() )
                    <li>
                        <form method="POST" action="{{ route('salir') }}">
                            @csrf
                            <a onclick="$(this).closest('form').submit()" title="Salir"  class="grey-text">
                                Salir
                            </a>
                        </form>
                    </li>
                @else
                    <li class="icono-registro">
                        <a class="InicioSesion" href="{{ route('admin') }}">
                            <i class="material-icons icono" >account_circle</i>
                            <span>Iniciar Sesión </span>
                        </a>
                    </li>
                @endif
            </ul>
        </nav>
    </div>
<!--Menú de navegación móvil-->
<ul class="sidenav" id="mobile-demo">
    <li>
        <a href="{{ route('home') }}" title="Home">Home</a>
    </li>
    <li>
        <a href="{{ route('comidas') }}" title="Comidas">Comidas</a>
    </li>
    <li>
        <a href="{{ route('term') }}" title="Acerca de">Acerca de</a>
    </li>
    <li>
        <div class="input-field col s6 s12 white-text">

            <i class="yellow-text material-icons prefix">search</i>
            <input type="text">
        </div>
    </li>
    @if( Auth::check() )
        <li>
            <form method="POST" action="{{ route('salir') }}">
                @csrf
                <a onclick="$(this).closest('form').submit()" title="Salir"  class="grey-text">
                    Salir
                </a>
            </form>
        </li>
    @else
        <li class="icono-registro">
            <a class="InicioSesion" href="{{ route('admin') }}">
                <i class="material-icons icono" >account_circle</i>
                <span>Iniciar Sesión </span>
            </a>
        </li>
    @endif
</ul>
<main>
    <section class="container-fluid ">
        <!--Content-->
    @yield('content')
    <!--Footer-->
    </section>
</main>
<footer class="center-align">
    <div class="modal-footer">
        <a href="#" class="modal-close waves-effect waves-light lighten-4 btn-flat white-text  ">Agree</a>
    </div>
    <a href="http://15.237.75.106/ProyectoDaw2022/proyecto-ReadyMeals/public/index.php " title="Ready Meals">
        © <?php echo date("Y") ?>
       Ready Meals
    </a>
</footer>
</body>
<!--Scripts-->
<script src="https://code.jquery.com/jquery-3.6.0.min.js" integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0/js/materialize.min.js"></script>
<script src="{{ asset('js/app.js') }}" defer></script>
</html>
