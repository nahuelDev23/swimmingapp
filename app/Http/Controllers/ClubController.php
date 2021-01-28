<?php

namespace App\Http\Controllers;

use App\Models\Club;
use Illuminate\Http\Request;

class ClubController extends Controller
{

    
    public function index()
    {
        
    }

    public function create()
    {
        $clubs = Club::withCount('alumnos')->get();
        return view('clubs/create',[
            'clubs' => $clubs,
        ]);
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'nombre_club' => 'required|unique:clubs,nombre_club',
        ]);
        $club = new Club;
        #PRIMER LETRA EN MAYUS , RESTO MUNUS
        $club->nombre_club = str_replace('\' ', '\'', ucwords(str_replace('\'', '\' ', strtolower($request->nombre_club))));
        $club->save();

        return back()->with('message','El club se agrego correctamente');
    }

    public function edit(Club $club)
    {
        return view('clubs/edit',[
            'club' => $club,
        ]);
    }

    public function update(Request $request,Club $club)
    {
        $club->nombre_club = $request->nombre_club;
        $club->update();

        return back()->with('message','El club se edito correctamente');
    }
}
