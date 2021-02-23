<?php

namespace App\Repositories\UsesCase\Categoria;
use App\Models\Categoria;
use Illuminate\Support\Collection;

class getAllCategoriasOrderByNombreCategoriaListForSelectInput
{

    public function execute()
    {
        return $this->getAllCategoriasOrderByNombreCategoriaListForSelectInput();
    }
  
    public function getAllCategoriasOrderByNombreCategoriaListForSelectInput(): Collection 
    {
       return Categoria::pluck('nombre_categoria','id');
    }
}
