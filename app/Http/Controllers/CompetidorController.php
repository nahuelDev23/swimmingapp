<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class CompetidorController extends Controller
{
    public function create(){
        return view('competidores/create');
    }
}
