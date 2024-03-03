@extends('layouts.admin')
@section('content')
    <div class="row">
        @foreach ($rowset as $row)
            <article class="col m12 l6">
                <div class="ft-recipe">
                    <div class="ft-recipe__thumb card horizontal small hoverable">
                        {{ Html::image('img/'.$row->imagen, $row->titulo) }}
                    </div>
                    <div class="ft-recipe__content">
                        <div class="content__header">
                            <div class="row-wrapper">
                                <h2 class="recipe-title">{{ $row->titulo }}</h2>
                                <div class="user-rating"></div>
                            </div>
                            <div class="row-wrapper">
                                <h5>Autor: <span style="color:#ff4f87"> {{$row -> autor}}</span></h5>
                            </div>
                            <ul class="recipe-details row-wrapper">
                                <!-- Tiempo-->
                                <li class="recipe-details-item time"><i class=" material-icons prefix"> schedule </i>
                                    <span class="value">{{$row -> tiempo}}</span><span class="title">Minutos</span></li>
                                <!-- Ingredientes--->
                                <li class="recipe-details-item ingredients"><i class=" material-icons prefix">
                                        bookmark</i></i><span class="value">{{ $row -> contador}}</span><span
                                        class="title">Ingredients</span></li>
                                <!-- Personas--->
                                <li class="recipe-details-item servings"><i
                                        class="material-icons prefix">person </i><span
                                        class="value">{{$row->personas}} </span> <span class="title"> Personas </span>
                                </li>
                            </ul>
                            <ul class="center-block  recipe-details row-wrapper">
                                <div class="card-action editar">
                                    <a href="{{ url("admin/comidas/editar/".$row->id) }}" title="Editar">
                                        <i class="material-icons">edit</i>
                                        <span style="color:#ff4f87">Modificar:</span>

                                    </a>
                                </div>
                            </ul>


                            <p class="description"><i class=" material-icons prefix">
                                    description</i> {{ $row->entradilla  }} </p>
                            <footer class="content__footer"><a href="{{ url('comida/'.$row->slug.'/'.$row->id) }}">
                                    Mirar Receta</a>
                            </footer>
                        </div>
                    </div>
            </article>
        @endforeach
    </div>
@endsection


