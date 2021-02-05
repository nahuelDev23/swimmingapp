<?php

namespace App\Observers;

use App\Models\Alumno;

class AlumnoObserver
{
    /**
     * Handle the Alumno "created" event.
     *
     * @param  \App\Models\Alumno  $alumno
     * @return void
     */
    public function created(Alumno $alumno)
    {
      
    //  dd('se guardo');
    }

    /**
     * Handle the Alumno "updated" event.
     *
     * @param  \App\Models\Alumno  $alumno
     * @return void
     */
    public function updated(Alumno $alumno)
    {
        //
    }

    /**
     * Handle the Alumno "deleted" event.
     *
     * @param  \App\Models\Alumno  $alumno
     * @return void
     */
    public function deleted(Alumno $alumno)
    {
        //
    }

    /**
     * Handle the Alumno "restored" event.
     *
     * @param  \App\Models\Alumno  $alumno
     * @return void
     */
    public function restored(Alumno $alumno)
    {
        //
    }

    /**
     * Handle the Alumno "force deleted" event.
     *
     * @param  \App\Models\Alumno  $alumno
     * @return void
     */
    public function forceDeleted(Alumno $alumno)
    {
        //
    }
}
