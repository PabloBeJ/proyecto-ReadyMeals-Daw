<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <!--Metas-->
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="title" content="Panel de administración">
    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ config('app.name', 'Inicio De Sesión') }}</title>
    <link rel="icon" type="image/x-icon" href="../public/img/LogoReadyMeals.jpg">
    <!-- Styles -->
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0/css/materialize.min.css">
    <link href="{{ asset('css/admin.css') }}" rel="stylesheet">
    <!-- Fuente -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@900&display=swap" rel="stylesheet">
</head>
<body>
<div class="nav-wrapper">
    <div class="navegacion">
        <!--Logo-->
        <div class="titulo">
            <a href="{{ route('home') }}" class="brand-logo" title="Inicio">
                {{ Html::image('img/LogoReadyMeals.jpg', 'Logo Ready Meals') }}
            </a>
            <h1><a href="{{ route('home') }}">Ready Meals </a></h1>
        </div>
        <nav>
            <!--Botón menú móviles-->
            <a href="#" data-target="mobile-demo" class="sidenav-trigger fixed-top right"><i
                    class="material-icons right-align">menu</i></a>
            <!--Menú de navegación-->
            <ul id="nav-mobile" class="nav-nomobile right hide-on-med-and-down">
                <li>
                    <form class="form-inline my-2 my-lg-0" action="{{url('/buscador')}}">
                        <div class="input-field  white-text">
                            <i class="yellow-text material-icons prefix">search</i>
                            <input name="query" type="text" value="{{old('query')}}" style="color:white;" required autofocus>
                        </div>
                    </form>
                </li>
                @if( Auth::check() )
                    <li>
                        <a href="{{ route('miscomidas' , ['nombre' => Auth::user()->usuario]) }}" title="Mis Recetas">Mis
                            Recetas</a>
                    </li>
                    <li>
                        <a href="{{ url('admin/comidas/crear') }}" title="Crear Receta">
                            <i class="material-icons prefix">add_circle_outline</i></a>
                    </li>
                    <li>
                        <a  href="{{ url("admin/usuarios/editar/".Auth::user()->id)  }}" title="Mi Perfil">
                            @if (Auth::user()->perfilimg)
                                <img   style="border-radius: 80%; margin-top: 10px " src="{{ asset('/img/'.Auth::user()->perfilimg )}}" width="60" height="60">
                            @endif
                            @if (!Auth::user()->perfilimg)
                                <i class="material-icons prefix">account_circle</i>
                            @endif
                        </a>
                    </li>
                    @if( Auth::user()->comidas )
                        <li>
                            <a href="{{ url('admin/comidas') }}" title="Recetas">Recetas</a>
                        </li>
                    @endif
                    @if( Auth::user()->usuarios )
                        <li>
                            <a href="{{ url('admin/usuarios') }}" title="Usuarios">Usuarios</a>
                        </li>
                    @endif
                    <li>
                        <form method="POST" action="{{ route('salir') }}">
                            @csrf
                            <a onclick="$(this).closest('form').submit()" title="Salir" class="grey-text">
                                Salir
                            </a>
                        </form>
                    </li>
                @else
                    <li class="icono-registro">
                        <a class="InicioSesion" href="{{ route('admin') }}">
                            <i class="material-icons icono">account_circle</i>
                            <span>Iniciar Sesión </span>
                        </a>
                    </li>
                @endif
            </ul>
        </nav>
    </div>
</div>

<!--Menú de navegación móvil-->
<ul class="sidenav" id="mobile-demo">
    <li>
        <a href="{{ route('comidas') }}" title="Comidas">Comidas</a>
    </li>
    <li>
        <form class="form-inline my-2 my-lg-0" action="{{url('/buscador')}}">
            <div class="input-field  white-text">
                <i class="yellow-text material-icons prefix" required autofocus>search</i>
                <input name="query" type="text">
            </div>
        </form>
    </li>

    @if( Auth::check())
        <li>
            <a href="{{ route('miscomidas' , ['nombre' => Auth::user()->nombre]) }}" title="Mis Recetas">Mis Recetas</a>
        </li>
    @endif

    @if( Auth::check() )
        @if( Auth::user()->comidas )
            <li>
                <a href="{{ url('admin/comidas') }}" title="Recetas">Recetas</a>
            </li>
        @endif
        @if( Auth::user()->usuarios )
            <li>
                <a href="{{ url('admin/usuarios') }}" title="Usuarios">Usuarios</a>
            </li>
        @endif
    @endif
    @if( Auth::check() )
        <li>
            <form method="POST" action="{{ route('salir') }}">
                @csrf
                <a onclick="$(this).closest('form').submit()" title="Salir" class="grey-text">
                    Salir
                </a>
            </form>
        </li>
    @else
        <li class="icono-registro">
            <a class="InicioSesion" href="{{ route('admin') }}">
                <i class="material-icons icono">account_circle</i>
                <span>Iniciar Sesión </span>
            </a>
        </li>
    @endif
</ul>

<!-- Mensajes  -->
@include('admin.partials.mensajes')
<main>
    <section class="container-fluid">
        <!--Content-->
        @yield('content')
    </section>
</main>
<footer class="center-align page-footer piePag">
    © <?php  echo date("Y")  ?> Copyright:
    <a href="{{route('term')}}" title="Informacion">
        Ready Meals
    </a>
</footer>
</body>
<!--Scripts-->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"
        integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0/js/materialize.min.js"></script>
<script src="{{ asset('js/admin.js') }}" defer></script>
</html>
