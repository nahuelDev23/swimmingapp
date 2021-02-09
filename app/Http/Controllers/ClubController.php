<?php

namespace App\Http\Controllers;

use App\Models\Club;
use Illuminate\Http\Request;
use App\Http\Requests\AddClubRequest;
use App\Repositories\ClubRepository;

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

    public function store(AddClubRequest $request,ClubRepository $clubRepository)
    {
       return  $clubRepository->create($request);
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
