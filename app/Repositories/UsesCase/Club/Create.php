<?php

namespace App\Repositories\UsesCase\Club;
use App\Models\Club;
<<<<<<< HEAD:app/Repositories/ClubRepository.php
use App\Http\Helpers;
use Illuminate\Support\Collection;

=======
use  App\Http\Helpers;
>>>>>>> 13e26ee5add33e438f16afee0fefbb9390c2316a:app/Repositories/UsesCase/Club/Create.php

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
