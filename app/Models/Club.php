<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Club extends Model
{
    use HasFactory;

    public function competidores()
    {
        return $this->hasMany(Competidor::class); # un Club tiene muchos competidores
    }
}
