@extends('layouts.admin')
@section('content')
    <h3>Crear Cuenta</h3>
    <div class="row formulario" >
        <form class="col s12 center-align " method="POST" action="{{ route('registrarse') }}">
            @csrf
            <div class="row">
                <div class="input-field col s12">
                    <input  id="usuario" type="text" name="usuario"value="{{ old('usuario') }}"required autofocus>
                    <label for="usuario">Usuario</label>
                    @if ($errors->has('usuario'))
                        <span class="invalid-feedback">
                 <strong style="color: red">Este usuario ya existe</strong>
                    </span>
                    @endif
                </div>
                <div class="input-field col s12">
                    <input  id="nombre" type="text" name="nombre" value="{{ old('nombre') }}"required autofocus>
                    <label for="nombre">Nombre</label>
                </div>
                <div class="input-field  col s12">
                    <input   class="validate" id="email" type="email"  name="email" value="{{ old('email') }}" required>
                    <span class="helper-text" data-error="Email incorrecto" data-success="Correcto"></span>
                    <label for="email">E-mail</label>
                </div>
                    <div class="file-field input-field col  s12">
                        <div class="btn">
                            <span>Foto De Perfil</span>
                            <input type="file" name="perfilimg" value="{{ old('perfilimg') }}">
                        </div>
                        <div class="file-path-wrapper">
                            <input class="file-path validate" type="text">
                        </div>
                    </div>
                <div class="input-field col s12">
                    <input    id="password" type="password" name="password" value="" required>
                    <label for="password">Contraseña</label>
                    <span class="helper-text" data-error="Requisitos 1 numero y una mayuscula"></span>
                </div>
                <div class="input-field col s12">
                    <input   id="password-confirm" type="password" name="password_confirmation" value="" required>
                    <label for="password-confirm">Repetir contraseña</label>
                    <span class="helper-text" data-error="Error Contraseña"></span>
                </div>
                <div class="input-field col s12">
                    <a href="{{ route('admin') }}" title="Volver">
                        <button class="btn waves-effect waves-light" type="button">Volver
                            <i class="material-icons right">refresh</i>
                        </button>
                    </a>
                    <button class="btn waves-effect waves-light" type="submit">Crear Cuenta
                        <i class="material-icons right">person</i>
                    </button>
                </div>
            </div>
        </form>
    </div>
@endsection
