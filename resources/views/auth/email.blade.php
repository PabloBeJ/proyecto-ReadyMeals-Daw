@extends('layouts.admin')

@section('content')

    <h3>Cambiar contraseña</h3>
    <div class="row formulario">
        <div class="row">
            <form class="col m12 l6" method="POST" action="{{ route('enlace') }}">
                @csrf
                <div class="row">
                    <div class="input-field col s12">
                        <input id="email" type="text" name="email" value="">
                        <label for="email">E-mail</label>
                        @error("email")
                            <span class="red-text text-darken-1">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="input-field col s12">
                        <a href="{{ route('admin') }}" title="Volver">
                            <button class="btn waves-effect waves-light" type="button">Volver
                                <i class="material-icons right">refresh</i>
                            </button>
                        </a>
                        <button class="btn waves-effect waves-light" type="submit">Solicitar cambio
                            <i class="material-icons right">send</i>
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>
@endsection
