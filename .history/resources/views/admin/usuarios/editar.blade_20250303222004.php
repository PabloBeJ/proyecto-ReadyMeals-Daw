@extends('layouts.admin')
@section('content')
    <div class="row formulario">
        @php $accion = ($row->id) ? "actualizar/".$row->id : "guardar" @endphp
        <form class="col m12 l6" enctype="multipart/form-data"  method="POST" action="{{ url("admin/usuarios/".$accion) }}">
            @csrf
            @method('POST')
            <div class="row">
                <div class="input-field col s12">
                    <input id="nombre" type="text" name="nombre" value="{{ $row->nombre }}">
                    <label for="nombre">Nombre</label>
                </div>
                <div class="input-field col s12">
                    <input id="email" type="text" name="email" value="{{ $row->email }}">
                    <label for="email">E-mail</label>
                </div>
                @php $clase = ($row->id) ? "hide" : "" @endphp
                <div class="input-field col s12 {{ $clase }}" id="password">
                    <input id="password" type="password" name="password" value="">
                    <label for="password">Contraseña</label>
                </div>
                @if ($row->id)
                    <p>
                        <label for="cambiar_clave">
                            <input id="cambiar_clave" name="cambiar_clave" type="checkbox">
                            <span>Pulsa para cambiar la clave</span>
                        </label>
                    </p>
                @else
                    <input type="hidden" name="cambiar_clave" value="1">
                @endif
                <div class="col m12 l6 center-align">
                    <div class="file-field input-field">
                            <div class="btn">
                                <span>Imagen</span>
                                <input type="file" name="imagen">
                            </div>
                            <div class="file-path-wrapper">
                                <input class="file-path validate" type="text">
                            </div>
                    </div>
                    @if ($row->perfilimg)
                        {{ Html::image('img/'.$row->perfilimg, $row->usuario, ['class' => 'responsive-img']) }}
                    @endif
                </div>
            </div>
            <div class="row">
                @if( Auth::check() )
                    @if( Auth::user()->comidas  || Auth::user()->usuarios)
                        <p>Permisos</p>
                        @if( Auth::user()->comidas)
                            <p>
                                <label for="comidas">
                                    <input id="comidas" name="comidas"
                                           type="checkbox" {{ ($row->comidas == 1) ? "checked" : "" }}>
                                    <span>Comidas</span>
                                </label>
                            </p>
                        @endif
                        @if( Auth::user()->usuarios)
                            <p>
                                <label for="usuarios">
                                    <input id="usuarios" name="usuarios"
                                           type="checkbox" {{ ($row->usuarios == 1) ? "checked" : "" }}>
                                    <span>Usuarios</span>
                                </label>
                            </p>
                            @endif
                        @endif
                @endif
                        <div class="input-field col s12">
                            <a href="{{ url("admin/usuarios") }}" title="Volver">
                                <button class="btn waves-effect waves-light" type="button">Volver
                                    <i class="material-icons right">replay</i>
                                </button>
                            </a>
                            <button class="btn waves-effect waves-light" type="submit" name="guardar">Guardar
                                <i class="material-icons right">save</i>
                            </button>
                        </div>
            </div>
        </form>
    </div>


@endsection
