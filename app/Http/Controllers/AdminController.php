<?php

namespace App\Http\Controllers;

  class AdminController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    public function index()
    {
        return redirect('/')->with('Bienvenido chef espero que encuentres tu receta ideal.');;
    }
}
