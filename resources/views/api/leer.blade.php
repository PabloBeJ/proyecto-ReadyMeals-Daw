
<style>
    html{
        margin: 1rem;
    }
    h1{
        margin-bottom: 2rem;
    }
    ul{
        list-style: none;
        padding: 0 0 1rem 0;
        border-b    ottom: 1px solid black;
    }
    li{
        display: inline-block;
    }
    li:first-child{
        width: 10rem;
    }
    li:first-child img{
        width: 8rem;
    }
    li:last-child{
        width: 80%;
    }
    h2{
        margin-top: 0;
    }
    a,
    a:visited{
        color: black;
    }
</style>

<h1>Listado de Comidas</h1>

    <?php foreach ($rowset as $row): ?>
        <ul>
        <li><img src="{{ asset('img/'.$row['imagen']) }}" alt="{{ $row['titulo'] }}">   </li>
            <li>
                <h2><?php echo $row['titulo'] ?></h2>
                <p><?php echo $row['entradilla'] ?></p>
                <p>
                    Por <strong><?php echo $row['autor'] ?></strong> el <strong><?php echo $row['fecha'] ?></strong>
                </p>
                <a href="{{ asset('comida/'.$row['slug'].'/'.$row['id']) }}" title="Más información" target="_blank">
                    Más Información
                </a>
            </li>
        </ul>

    <?php endforeach; ?>
