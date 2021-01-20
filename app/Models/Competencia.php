<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Competencia extends Model
{
    use HasFactory;

    public function series()
    {
        return $this->hasMany(Serie::class); # una Competencia tiene muchas series
    }
    public function cancheos()
    {
        return $this->hasMany(Cancheo::class); # una Competencia tiene muchas cancheos
    }

    public function competidores()
    {
        return $this->hasMany(Competidor::class); # una Competencia tiene muchas competidores
    }
}
