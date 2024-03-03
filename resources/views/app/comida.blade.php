@extends('layouts.admin')

@section('content')

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
                            class="title">Ingredientes</span></li>
                    <!-- Personas--->
                    <li class="recipe-details-item servings"><i
                            class="material-icons prefix">person </i><span
                            class="value">{{$row->personas}} </span> <span class="title"> Personas </span>
                    </li>
                </ul>
            </div>
            <h2>Ingredientes:</h2>
            <p class="description" {{ $row->descripcion  }} </p>
            <ul class="recipe-details row-wrapper">
                <!-- Recorre todos los ingredientesque tiene en la base de datos--->
                @foreach ($rowsetIngre as $rowIngredientes)
                    <li>
                    <li class="detalle"><i class=" material-icons green-text prefix">
                            <!-- El valor de la tabla de ingredientes el atributo ingredientes se imprima aqui--->
                            check_circle</i></i>{{$rowIngredientes->ingredientes}} <i class=" material-icons prefix">
                            navigate_next </i>
                        <!-- El valor de la tabla de ingredientes el atributo peso se imprima aqui--->
                        {{$rowIngredientes->peso}}   </span></li>
                @endforeach
            </ul>
            <h2>Descripción</h2>
            <p class="description"> {{ $row->descripcion  }} </p>
            <footer class="content__footer"><a href="{{ url('/') }}"> Volver</a>
            </footer>
        </div>
    </div>
@endsection
