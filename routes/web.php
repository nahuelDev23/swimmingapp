<?php


use App\Http\Controllers\CompetenciaController;
use App\Http\Controllers\CompetidorController;
use App\Http\Controllers\ResultadoController;
use App\Http\Controllers\PruebaController;
use App\Http\Controllers\SerieController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\AlumnoController;
use App\Http\Controllers\CancheoController;
use App\Http\Controllers\ClubController;
use App\Http\Controllers\InscripcionPruebaController;
use Illuminate\Support\Facades\Route;

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

Route::get('/dashboard',[CompetenciaController::class,'index'])->middleware(['auth'])->name('dashboard');
Route::get('competencias/generarSeriesCancheos/{competencia}',[CompetenciaController::class,'generarSeriesCancheos'])->middleware(['auth','resetPassword'])->name('competencias.generarSeriesCancheos');
Route::resource('competencias',CompetenciaController::class)->middleware(['auth','resetPassword']);


Route::get('series/{serie}',[SerieController::class,'show'])->middleware(['auth','resetPassword'])->name('series.show');
Route::get('series/create/{competencia}',[SerieController::class,'create'])->middleware(['auth','resetPassword'])->name('series.create');
Route::post('series',[SerieController::class,'store'])->middleware(['auth','resetPassword'])->name('series.store');

Route::resource('users',UserController::class)->middleware(['auth','resetPassword']);

Route::get('users/reset-password')->middleware(['auth','resetPassword'])->name('users.reset-password');
Route::post('users/reset-password',[UserController::class,'reset_password'])->middleware(['auth','resetPassword'])->name('users.reset-password');


Route::get('alumnos/create',[AlumnoController::class,'create'])->middleware(['auth','resetPassword'])->name('alumnos.create');
Route::post('alumnos/import',[AlumnoController::class,'import'])->middleware(['auth','resetPassword'])->name('alumnos.import');
Route::get('alumnos/{alumno}/edit',[AlumnoController::class,'edit'])->middleware(['auth','resetPassword'])->name('alumnos.edit');
Route::resource('alumnos',AlumnoController::class,['except' => ['create','edit']])->middleware(['auth','resetPassword']);


Route::get('competidores/create/{competencia}',[CompetidorController::class,'create'])->middleware(['auth','resetPassword'])->name('competidores.create');
Route::get('competidores/{competidore}/edit',[CompetidorController::class,'edit'])->middleware(['auth','resetPassword'])->name('competidores.edit');
Route::resource('competidores',CompetidorController::class,['except' => ['create','edit']])->middleware(['auth','resetPassword']);

Route::get('inscripciones/create/{competencia}',[InscripcionPruebaController::class,'create'])->middleware(['auth','resetPassword'])->name('inscripciones.create');
Route::get('inscripciones/edit',[InscripcionPruebaController::class,'edit'])->middleware(['auth','resetPassword'])->name('inscripciones.edit');
Route::resource('inscripciones',InscripcionPruebaController::class,['except' => ['create','edit']])->middleware(['auth','resetPassword']);

Route::get('cancheos/create/{competencia}',[CancheoController::class,'create'])->middleware(['auth','resetPassword'])->name('cancheos.create');
Route::get('cancheos/{cancheo}/edit',[CancheoController::class,'edit'])->middleware(['auth'])->name('cancheos.edit');
Route::resource('cancheos',CancheoController::class,['except' => ['create','edit']])->middleware(['auth','resetPassword']);

Route::get('pruebas/create/{competencia}',[PruebaController::class,'create'])->middleware(['auth','resetPassword'])->name('pruebas.create');
Route::get('pruebas/{prueba}/edit',[PruebaController::class,'edit'])->middleware(['auth','resetPassword'])->name('pruebas.edit');
Route::resource('pruebas',PruebaController::class,['except' => ['create','edit']])->middleware(['auth','resetPassword']);

Route::get('resultados/puntuaciongeneral',[ResultadoController::class,'puntuacionGeneral'])->middleware(['auth','resetPassword'])->name('resultados.puntuaciongeneral');
Route::get('resultados/{competencia}',[ResultadoController::class,'show'])->middleware(['auth','resetPassword'])->name('resultados.show');
Route::post('resultados/{competencia}',[ResultadoController::class,'store'])->middleware(['auth','resetPassword'])->name('resultados.store');

Route::resource('resultados',ResultadoController::class,['except' => ['create','edit','show','store']])->middleware(['auth','resetPassword']);

Route::resource('clubs',ClubController::class)->middleware(['auth','resetPassword']);

require __DIR__.'/auth.php';
