<?php

namespace App\Http\Controllers;

use App\Models\Comida;
use App\Models\Ingredientes;

class AppController extends Controller
{
    public function index()
    {
        //Obtengo las comidas a mostrar en la home
        $rowset = Comida::where('activo', 1)->orderBy('fecha', 'DESC')->get();

        return view('app.index', [
            'rowset' => $rowset,
        ]);
    }

    public function comidas()
    {
        //Obtengo las comidas a mostrar en el listado de comidas
        $rowset = Comida::where('activo', 1)->orderBy('fecha', 'DESC')->get();

        return view('app.comidas', [
            'rowset' => $rowset,
        ]);
    }

    public function comida($slug, $id)
    {
        //Obtengo la comida o muestro error
        $row = Comida::where('activo', 1)->where('slug', $slug)->firstOrFail();
        $rowsetIngre = Ingredientes::orderBy('ingredientes', 'DESC')->firstOrFail()
            ->join('comidas', 'comidas.id', '=', 'ingredientes.idComida')
            ->where('idComida', $id)
            ->get();
        return view('app.comida', [
            'row' => $row,
            'rowsetIngre' => $rowsetIngre,
        ]);
    }

    public function term()
    {
        return view('app.acerca-de');
    }

    public function buscador()
{
    $buscar_texto = $_GET['query'];

    // Get all comidas ordered by the most recent fecha
    $rowset = Comida::orderBy('fecha', 'DESC')->firstOrFail()
        ->where('titulo', 'LIKE', '%' . $buscar_texto . '%')
        ->orWhere('autor', 'LIKE', '%' . $buscar_texto . '%')
        ->get();

    return view('app.comidas', compact('rowset')); // Correct usage
}

}
