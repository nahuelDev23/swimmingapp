<?php

namespace App\Http\Controllers;

use App\Models\Club;
use Illuminate\Http\Request;
use App\Http\Requests\AddClubRequest;
use App\Repositories\UsesCase\Club\Create;
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

    public function store(AddClubRequest $request)
    {
       $store = new Create();
       return  $store->execute($request);
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
