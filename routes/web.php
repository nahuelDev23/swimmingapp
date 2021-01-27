<?php


use App\Http\Controllers\CompetenciaController;
use App\Http\Controllers\CompetidorController;
use App\Http\Controllers\ResultadoController;
use App\Http\Controllers\PruebaController;
use App\Http\Controllers\SerieController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\AlumnoController;
use App\Http\Controllers\CancheoController;
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
Route::get('competencias/{competencia}',[CompetenciaController::class,'show'])->middleware(['auth'])->name('competencias.show');
Route::get('competencias/generarSeriesCancheos/{competencia}',[CompetenciaController::class,'generarSeriesCancheos'])->middleware(['auth'])->name('competencias.generarSeriesCancheos');

Route::get('series/{serie}',[SerieController::class,'show'])->middleware(['auth'])->name('series.show');
Route::get('series/create/{competencia}',[SerieController::class,'create'])->middleware(['auth'])->name('series.create');
Route::post('series',[SerieController::class,'store'])->middleware(['auth'])->name('series.store');

Route::resource('users',UserController::class)->middleware(['auth']);

Route::get('users/reset-password')->middleware(['auth'])->name('users.reset-password');
Route::post('users/reset-password',[UserController::class,'reset_password'])->middleware(['auth'])->name('users.reset-password');


Route::get('alumnos/create',[AlumnoController::class,'create'])->middleware(['auth'])->name('alumnos.create');
Route::get('alumnos/edit',[AlumnoController::class,'edit'])->middleware(['auth'])->name('alumnos.edit');
Route::resource('alumnos',AlumnoController::class,['except' => ['create','edit']])->middleware(['auth']);


Route::get('competidores/create/{competencia}',[CompetidorController::class,'create'])->middleware(['auth'])->name('competidores.create');
Route::get('competidores/{competidore}/edit',[CompetidorController::class,'edit'])->middleware(['auth'])->name('competidores.edit');
Route::resource('competidores',CompetidorController::class,['except' => ['create','edit']])->middleware(['auth']);

Route::get('inscripciones/create/{competencia}',[InscripcionPruebaController::class,'create'])->middleware(['auth'])->name('inscripciones.create');
Route::get('inscripciones/edit',[InscripcionPruebaController::class,'edit'])->middleware(['auth'])->name('inscripciones.edit');
Route::resource('inscripciones',InscripcionPruebaController::class,['except' => ['create','edit']])->middleware(['auth']);

Route::get('cancheos/create/{competencia}',[CancheoController::class,'create'])->middleware(['auth'])->name('cancheos.create');
Route::get('cancheos/{cancheo}/edit',[CancheoController::class,'edit'])->middleware(['auth'])->name('cancheos.edit');
Route::resource('cancheos',CancheoController::class,['except' => ['create','edit']])->middleware(['auth']);

Route::get('pruebas/create/{competencia}',[PruebaController::class,'create'])->middleware(['auth'])->name('pruebas.create');
Route::get('pruebas/{prueba}/edit',[PruebaController::class,'edit'])->middleware(['auth'])->name('pruebas.edit');
Route::resource('pruebas',PruebaController::class,['except' => ['create','edit']])->middleware(['auth']);

Route::get('resultados/{competencia}',[ResultadoController::class,'show'])->middleware(['auth'])->name('resultados.show');
Route::post('resultados/{competencia}',[ResultadoController::class,'store'])->middleware(['auth'])->name('resultados.store');
Route::resource('resultados',ResultadoController::class,['except' => ['create','edit','show','store']])->middleware(['auth']);
require __DIR__.'/auth.php';
