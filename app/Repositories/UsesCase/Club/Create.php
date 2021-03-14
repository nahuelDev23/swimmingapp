<?php

namespace App\Repositories\UsesCase\Club;
use App\Models\Club;
use  App\Http\Helpers;

class Create
{
    public function execute($request)
    {
        return $this->create($request);
    }
  
    public function create($request)
    {
        $club = new Club;
        $club->nombre_club = Helpers::makeOnlyFirstLetterUppercase($request->nombre_club);
        $club->save();

        return back()->with('message','El club se agrego correctamente');
    }
}
