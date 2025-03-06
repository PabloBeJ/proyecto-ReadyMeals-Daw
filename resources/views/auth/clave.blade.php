@extends('layouts.admin')

@section('content')

    <h3>Cambiar contraseña</h3>
    <div class="row formulario">
        <div class="row">
            <form class="col m12 l6" method="POST" action="{{ route('cambiar') }}">
                @csrf
                <input type="hidden" name="token" value="{{ $token }}">
                <div class="row">
                    <div class="input-field col s12">
                        <input id="email" type="text" name="email" value="" required autofocus>
                        <label for="email">E-mail</label>
                        @error("email")
                            <span class="red-text text-darken-1">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="input-field col s12">
                        <input id="password" type="password" name="password" value="" required>
                        <label for="password">Contraseña</label>
                        @error("password")
                            <span class="red-text text-darken-1">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="input-field col s12">
                        <input id="password-confirm" type="password" name="password_confirmation" value="" required>
                        <label for="password-confirm">Repetir contraseña</label>
                        @error("password_confirmation")
                            <span class="red-text text-darken-1">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="input-field col s12">
                        <a href="{{ route('admin') }}" title="Volver">
                            <button class="btn waves-effect waves-light" type="button">Volver
                                <i class="material-icons right">refresh</i>
                            </button>
                        </a>
                        <button class="btn waves-effect waves-light" type="submit">Cambiar contraseña
                            <i class="material-icons right">person</i>
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>
@endsection
