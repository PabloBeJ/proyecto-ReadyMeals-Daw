@extends('layouts.admin')

@section('content')
    <h3>
        <a href="{{ route("admin") }}" title="Inicio">Inicio</a> <span>| Usuarios</span>
    </h3>
       <!--Paginación-->
       <div class="row paginado">
        {{ $rowset->links() }}
    </div>
    <div class="row">
        <!--Nuevo-->
        <article class="col s12 l6">
            <div class="card horizontal admin">
                <div class="card-stacked">
                    <div class="card-content">
                        <i class="grey-text material-icons medium">person</i>
                        <h4 class="grey-text">
                            nuevo usuario
                        </h4><br><br>
                    </div>
                    <div class="card-action">
                        <a href="{{ url("admin/usuarios/crear") }}" title="Añadir nuevo usuario">
                            <i class="material-icons">add_circle</i>
                        </a>
                    </div>
                </div>
            </div>
        </article>
        @foreach ($rowset as $row)
            <article class="col s12 l6">
                <div class="card horizontal  sticky-action admin">
                    <div class="card-stacked">
                        <div class="card-content">
                            <h4>
                                {{ $row->usuario }}
                            </h4>
                            @if ($row->perfilimg)
                                <div class="card-image">
                                    {{ Html::image('img/'.$row->perfilimg, $row->titulo) }}
                                </div>
                            @endif
                            <div class="card-content">
                                @if (!$row->perfilimg)
                                    <i class="grey-text material-icons medium">image</i>
                                @endif
                                <strong>Usuarios: </strong>{{ ($row->usuarios) ? "Sí" : "No" }}<br>
                                <strong>Comdias: </strong>{{ ($row->comidas) ? "Sí" : "No" }}
                            </div>
                            <div class="card-action">
                                <a href="{{ url("admin/usuarios/editar/".$row->id) }}" title="Editar">
                                    <i class="material-icons">edit</i>
                                </a>
                                @php
                                    $title = ($row->activo == 1) ? "Desactivar" : "Activar";
                                    $color = ($row->activo == 1) ? "green-text" : "red-text";
                                    $icono = ($row->activo == 1) ? "mood" : "mood_bad";
                                @endphp
                                <a href="{{ url("admin/usuarios/activar/".$row->id) }}" title="{{ $title }}">
                                    <i class="{{ $color }} material-icons">{{ $icono }}</i>
                                </a>
                                <a href="#" class="activator" onclick="event.preventDefault(); this.closest('.card').querySelector('.card-reveal').classList.toggle('show');" title="Borrar">
                                    <i class="material-icons">delete</i>
                                </a>
                            </div>
                        </div>
                    </div>
                       <!--Confirmación de borrar-->
                       <div class="card-reveal">
                            <span class="card-title grey-text text-darken-4">Borrar usuario<i
                                    class="material-icons right">close</i></span>
                            <p style="color:#000;">
                                ¿Está seguro de que quiere borrar al usuario<strong>{{ $row->nombre }}</strong>?<br>
                                Esta acción no se puede deshacer.
                            </p>
                            <a href="{{ url("admin/usuarios/borrar/".$row->id) }}" title="Borrar">
                                <button class="btn waves-effect waves-light" type="button">Borrar
                                    <i class="material-icons right">delete</i>
                                </button>
                            </a>
                        </div>
                </div>
            </article>
        @endforeach
    </div>
@endsection
