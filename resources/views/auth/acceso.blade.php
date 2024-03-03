@extends('layouts.admin')
@section('content')
    <header>
        <h2> Inicia sesión para que encuentres una receta ideal</h2>
    </header>
    <div class="row formulario ">
        <form class="center-align  medium" method="POST" action="{{ route('autenticar') }}">
            @csrf
            <div class="row">
                <div class="input-field col s12">
                    <input id="email" type="email" name="email" value="{{old('email')}}">
                    <label for="email">E-mail</label>
                    @if ($errors->has('email'))
                        <span class="invalid-feedback">
                 <strong style="color: red">Correo Incorrecto</strong>
                    </span>
                    @endif
                </div>
                <div class="input-field col s12">
                    <input id="password" type="password" name="password" value="">
                    <label for="password">Contraseña</label>
                    @if ($errors->has('password'))
                        <span class="invalid-feedback">
                 <strong style="color: red">Contraseña Incorrecta</strong>
                    </span>
                    @endif
                </div>
                <div class="input-field col s12">
                    <a href="{{ route('email') }}" title="Cambiar contraseña">
                        <button class="waves-effect waves-light" type="button">Cambiar contraseña
                            <i class="material-icons right">help</i>
                        </button>
                    </a>
                    <button class="waves-effect waves-light" type="submit">Acceder
                        <i class="material-icons right">person</i>
                    </button>
                </div>
                <h3 style="color: black"> ¿No tienes cuenta?</h3>
                <a href="{{ route('registro') }}" title="Registrarse">
                    <button class=" waves-effect waves-light" type="button">Registrate
                        <i class="material-icons right">person_add</i>
                    </button>
                </a>
            </div>
        </form>
    </div>
@endsection
