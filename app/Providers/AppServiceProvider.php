<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Models\Alumno;
use App\Observers\AlumnoObserver;
class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        Alumno::observe(AlumnoObserver::class);
    }
}
