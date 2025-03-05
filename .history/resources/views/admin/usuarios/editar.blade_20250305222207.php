@extends('layouts.admin')

@section('content')
    <div class="row formulario">
        @php
            $accion = ($row->id) ? "actualizar/" . $row->id : "guardar";
        @endphp

        <form class="col m12 l6" enctype="multipart/form-data" method="POST" action="{{ url('admin/usuarios/' . $accion) }}">
            @csrf
            <div class="row">
                <div class="input-field col s12">
                    <input id="usuario" type="text" name="usuario" value="{{ $row->usuario }}">
                    <label for="usuario">Usuario</label>
                </div>
                <div class="input-field col s12">
                    <input id="nombre" type="text" name="nombre" value="{{ $row->nombre }}">
                    <label for="nombre">Nombre</label>
                </div>
                <div class="input-field col s12">
                    <input id="email" type="text" name="email" value="{{ $row->email }}">
                    <label for="email">E-mail</label>
                </div>
                @php
                    $clase = ($row->id) ? "hide" : "";
                @endphp

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

                <div class="input-field col s12 {{ $clase }}" id="password">
                    <input id="password" type="password" name="password" value="">
                    <label for="password">Contraseña</label>
                </div>

                <div class="input-field col s12 {{ $clase }}"  id="new_password">
                    <input id="new_password" type="password" name="new_password" value="">
                    <label for="new_password">Nueva Contraseña</label>
                </div>

                <div class="input-field col s12 {{ $clase }}"  id="passwordRepeat">
                    <input id="password_confirmation" type="password" name="password_confirmation" >
                    <label for="password_confirmation">Confirmar Contraseña</label>
                </div>

                <div class="col m12 l6 center-align">
                    <div class="file-field input-field">
                        <div class="btn">
                            <span>Imagen</span>
                            <input type="file" name="perfilimg">
                        </div>
                        <div class="file-path-wrapper">
                            <input class="file-path validate" type="text">
                        </div>
                    </div>
                    @if ($row->perfilimg)
                        {{ Html::image('img/' . $row->perfilimg, $row->usuario, ['class' => 'responsive-img']) }}
                    @endif
                </div>
            </div>

            <div class="row">
                @if(Auth::check())
                    @if(Auth::user()->comidas || Auth::user()->usuarios)
                        <p>Permisos</p>
                        @if(Auth::user()->comidas)
                            <p>
                                <label for="comidas">
                                    <input id="comidas" name="comidas" type="checkbox" {{ ($row->comidas == 1) ? "checked" : "" }}>
                                    <span>Comidas</span>
                                </label>
                            </p>
                        @endif
                        @if(Auth::user()->usuarios)
                            <p>
                                <label for="usuarios">
                                    <input id="usuarios" name="usuarios" type="checkbox" {{ ($row->usuarios == 1) ? "checked" : "" }}>
                                    <span>Usuarios</span>
                                </label>
                            </p>
                        @endif
                    @endif
                @endif

                <!-- Botones para volver y guardar-->
                <div class="row">
                    <div class="input-field col s12 center-align">
                        <a href="{{ url('/') }}" title="Volver">
                            <button class="btn waves-effect waves-light" type="button">Volver
                                <i class="material-icons right">replay</i>
                            </button>
                        </a>
                        <button class="btn waves-effect waves-light" type="submit" name="guardar">Guardar
                            <i class="material-icons right">save</i>
                        </button>

                        <!-- SI el boton tiene una id aparece el botón de borrar en el formulario-->
                        @if($row->id)
                            <!-- Trigger Modal to Confirm Deletion -->
                            <a href="#delete-modal" class="modal-trigger">
                                <button class="btn waves-effect waves-light" type="button">
                                    Borrar
                                    <i class="material-icons right">delete</i>
                                </button>
                            </a>
                        @endif
                    </div>
                </div>
        </form>
    </div>

    <!-- Modal Confirmation for Delete -->
    <div id="delete-modal" class="modal">
        <div class="modal-content">
            <h4>Confirmar Eliminación</h4>
            <form action="{{ route("admin/usuarios/borrar/".$row->id) }}" method="POST">
                @csrf
                <p>¿Estás seguro de que deseas eliminar tu cuenta?</p>
                <div class="input-field">
                    <input id="password" type="password" name="password" required>
                    <label for="password">Ingresa tu contraseña para confirmar</label>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn waves-effect waves-light">Confirmar</button>
                    <a href="#!" class="modal-close btn waves-effect waves-light red">Cancelar</a>
                </div>
            </form>
        </div>
    </div>

@endsection

@section('scripts')
    <script>
        // Initialize modal
        $(document).ready(function(){
            $('.modal').modal();  // Initializes the modal
        });
    </script>
@endsection
