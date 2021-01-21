<?php


use App\Http\Controllers\CompetenciaController;
use App\Http\Controllers\ResultadoController;
use App\Http\Controllers\SerieController;
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

Route::get('resultados/{competencia}',[ResultadoController::class,'show'])->middleware(['auth'])->name('resultados.show');
require __DIR__.'/auth.php';
