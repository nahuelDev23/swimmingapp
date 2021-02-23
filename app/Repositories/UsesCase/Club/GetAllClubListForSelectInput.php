<?php

namespace App\Repositories\UsesCase\Club;
use App\Models\Club;
use Illuminate\Support\Collection;

class GetAllClubListForSelectInput
{
    public function execute()
    {
        return $this->getAllClubListForSelectInput();
    }
  
    public function getAllClubListForSelectInput(): Collection 
    {
       return Club::pluck('nombre_club','id');
    }
}
