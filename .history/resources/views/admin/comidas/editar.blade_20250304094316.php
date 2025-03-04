@extends('layouts.admin')
@section('content')
    <h3>
        <span>Nueva Receta</span>
    </h3>
    <div class="row formulario">
        <!--Accion que indica si tiene id salga el boton de actualizar y si la id es nulo sale el boton de guardar -->
        @php $accion = ($row->id) ? "actualizar/".$row->id : "guardar" @endphp
        <form class="col s12" method="POST" enctype="multipart/form-data" action="{{ url("admin/comidas/".$accion) }}">
            @csrf
            <div class="col m12 l6">
                <div class="row">
                    <div class="input-field col s12">
                        <input id="titulo" type="text" required name="titulo" value="{{ $row->titulo }}">
                        <!--  Pregunta Por el titulo de la receta-->
                        <label for="titulo">Título</label>
                    </div>
                    <div class="input-field col s12">
                        <!--  Pregunta Por el titulo de la Entradilla-->
                        <input id="entradilla" required type="text" name="entradilla" value="{{ $row->entradilla }}">
                        <label for="entradilla">entradilla</label>
                    </div>
                    <!--  Aqui a traves de un formulario invisible pone los datos  automaticamente para los campos de fecha y autor-->
                    <div style="display: none">
                        <input id="autor" type="text" required name="autor" value="{{ Auth::user()->usuario }}">
                        <label for="autor">Autor</label>
                        @php $fecha = ($row->fecha) ? date("d-m-Y", strtotime($row->fecha)) : date("d-m-Y") @endphp
                        <input id="fecha" type="text" name="fecha" class="datepicker" value="{{ $fecha }}">
                    </div>
                </div>
            </div>
            <div class="col m12 l6 center-align">
                <div class="file-field input-field">
                    <div class="btn">
                        <!--  Pregunta Por la imagen-->
                        <span>Imagen</span>
                        <input type="file" name="imagen">
                    </div>
                    <div class="file-path-wrapper">
                        <input class="file-path validate" value="{{$row->imagen}}" required type="text">
                    </div>
                </div>
                <!--  Pregunta Si es para editar y tiene imagen se muestra la imagene seleccionado de la bbdd-->
                @if ($row->imagen)
                    {{ Html::image('img/'.$row->imagen, $row->titulo, ['class' => 'responsive-img']) }}
                @endif
            </div>
            <div class="col m12 l6 center-align">
                <div class="input-field col s12">
                    <!--  Pregunta Si es para editar y tiene imagen se muestra la imagene seleccionado de la bbdd-->
                    <input id="url" type="text" name="url" value="{{ $row->url }}">
                    <label for="url">url</label>
                </div>
            </div>
            <div class="col s12">
                <div class="row">
                    <div class="input-field col s12">
                        <!--  Pregunta `por los pasos de la receta-->
                        <textarea id="descripcion" required class="materialize-textarea"
                                  name="descripcion"> {{$row->descripcion}}</textarea>
                        <label for="descripcion">Descripcion</label>
                    </div>
                    <div class="input-field col s12">
                        <!--  Pregunta por el timepio que se crea la receta-->
                        <input id="tiempo" type="number" required name="tiempo" value="{{ $row->tiempo }}">
                        <label for="tiempo">Tíempo (minutos)</label>
                    </div>
                    <div class="input-field col s12">
                        <!--  Pregunta para la receta para cuantas personas son-->
                        <input id="personas" type="number" required name="personas" value="{{ $row->personas }}">
                        <label for="personas">Cantidad de personas</label>
                    </div>
                    <div class="m-3">
                        <!--  Formulario para los ingredientes-->
                        <table id="add_table" class="table" data-toggle="table" data-mobile-responsive="true">
                            <thead>
                            <tr>
                                <!--  Titulos-->
                                <th>Ingrediente</th>
                                <th>Peso</th>
                                <th>
                                    <!--  Boton para añadir ingrediente -->
                                    <button class="btn btn-outline-success" onClick="addRow()" type="button"
                                            id="add_row"  class="add"> Añadir
                                    </button>
                                </th>
                            </tr>
                            </thead>
                            <tbody>
                            <!--  Si es para el campo de id y tiene recetas se imprimre los ingredientes-->
                            @if($row->id)
                                <!--  Bucle para imprimir todas las recetas -->
                                @foreach ($rowset as $rowIngre)

                                    <tr>
                                        <td>
                                            <input type="text" class="form-control" placeholder="Añadir Ingrediente"
                                                   value="{{$rowIngre->ingredientes}}" name="ingredientes[]">
                                        </td>
                                        <td>
                                            <input type="text" class="form-control" placeholder="Añadir Peso"
                                                   value="{{$rowIngre->peso}}" name="peso[]">
                                        </td>
                                        <td>
                                            <button onclick="removeRow()" class="btn btn-outline-danger delete_row"
                                                    type="button">Eliminar
                                            </button>
                                        </td>
                                    </tr>

                                @endforeach
                            @endif
                            <!--  Si es para el campo de crear se muestra 1 ingrediente con sus dpos campos-->
                            @if(!$row->id)
                                <tr>
                                    <td>
                                        <!-- Texto para añadir ingrediente-->
                                        <input type="text" class="form-control" placeholder="Añadir Ingrediente"
                                               name="ingredientes[]">
                                    </td>
                                    <td>
                                        <!-- Texto para añadir peso-->
                                        <input type="text" class="form-control" placeholder="Añadir Peso" name="peso[]">
                                    </td>
                                    <td>
                                        <button onclick="removeRow()" class="btn btn-outline-danger delete_row"
                                                type="button">Eliminar
                                        </button>
                                    </td>
                                </tr>
                            @endif
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            <!-- Botones para volver y guardar-->
            <div class="row">
                <div class="input-field col s12 center-align">
                    <a href="{{ url("/") }}" title="Volver">
                        <button class="btn waves-effect waves-light" type="button">Volver
                            <i class="material-icons right">replay</i>
                        </button>
                    </a>
                    <button class="btn waves-effect waves-light" type="submit" name="guardar">Guardar
                        <i class="material-icons right">save</i>
                    </button>
                    <!-- SI el boton tiene una id aparece el botón de borrar en el formulario-->
                    @if($row->id)
                        <a href="{{ url("admin/comidas/borrar/".$row->id) }}" title="Borrar">
                            <button class="btn waves-effect waves-light" type="button">Borrar
                                <i class="material-icons right">delete</i>
                            </button>
                        </a>
                        @endif
                </div>
            </div>
        </form>
    </div>
@endsection
