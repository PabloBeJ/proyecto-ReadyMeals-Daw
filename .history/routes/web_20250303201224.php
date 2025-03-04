<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AppController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\UsuarioController;
use App\Http\Controllers\ComidaController;
/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

//Front-end
Route::get('/', [AppController::class, 'index'])->name('home');
Route::get('comidas', [AppController::class, 'comidas'])->name('comidas');
Route::get('comida/{slug}/{id}', [AppController::class, 'comida'])->name('comida');
Route::get('terminos', [AppController::class, 'term'])->name('term');



//Back-end
Route::get('admin', [AdminController::class, 'index'])->name('admin');
Route::get('admin/usuarios', [UsuarioController::class, 'index'])->middleware('role:usuarios');;
Route::get('admin/usuarios/crear', [UsuarioController::class, 'crear']);
Route::post('admin/usuarios/guardar', [UsuarioController::class, 'guardar']);
Route::get('admin/usuarios/editar/{id}', [UsuarioController::class, 'editar']);
Route::put('admin/usuarios/actualizar/{id}', [UsuarioController::class, 'actualizar']);
Route::get('admin/usuarios/activar/{id}', [UsuarioController::class, 'activar']);
Route::get('admin/usuarios/borrar/{id}', [UsuarioController::class, 'borrar']);

//Back-end
Route::get('admin', [AdminController::class, 'index'])->name('admin');
Route::get('admin/comidas', [ComidaController::class, 'index'])->middleware('role:comidas');
Route::get('admin/comidas/crear', [ComidaController::class, 'crear']);
Route::post('admin/comidas/guardar', [ComidaController::class, 'guardar']);
Route::get('admin/comidas/misComidas/{nombre}', [ComidaController::class, 'misComidas'])->name('miscomidas');
Route::get('admin/comidas/editar/{id}', [ComidaController::class, 'editar']);
Route::post('admin/comidas/actualizar/{id}', [ComidaController::class, 'actualizar']);
Route::get('admin/comidas/activar/{id}', [ComidaController::class, 'activar']);
Route::get('admin/comidas/home/{id}', [ComidaController::class, 'home']);
Route::get('admin/comidas/borrar/{id}', [ComidaController::class, 'borrar']);

//Buscador
Route::get('buscador',[AppController::class,'buscador']);

//Auth
Route::get('acceder', [AuthController::class, 'acceder'])->name('acceder');
Route::post('autenticar', [AuthController::class, 'autenticar'])->name('autenticar');
Route::get('registro', [AuthController::class, 'registro'])->name('registro');
Route::post('registrarse', [AuthController::class, 'registrarse'])->name('registrarse');
Route::post('salir', [AuthController::class, 'salir'])->name(  'salir');

//Mail
Route::get('email', [AuthController::class, 'email'])->name('email');
Route::post('enlace', [AuthController::class, 'enlace'])->name('enlace');
Route::get('clave/{token}', [AuthController::class, 'clave'])->name('clave');
Route::post('cambiar', [AuthController::class, 'cambiar'])->name('cambiar');
