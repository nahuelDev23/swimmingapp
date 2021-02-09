<?php
namespace App\Repositories;
use App\Models\Club;
use  App\Http\Helpers;
use Illuminate\Support\Collection;


class ClubRepository
{
    public function getAllClubListForSelectInput(): Collection 
    {
       return Club::pluck('nombre_club','id');
    }

    public function create($request)
    {
        $club = new Club;
        $club->nombre_club = Helpers::makeOnlyFirstLetterUppercase($request->nombre_club);
        $club->save();

        return back()->with('message','El club se agrego correctamente');
    }

}