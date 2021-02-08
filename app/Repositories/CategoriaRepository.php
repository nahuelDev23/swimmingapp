<?php
namespace App\Repositories;
use App\Models\Categoria;
use Illuminate\Support\Collection;


class CategoriaRepository
{
    public function getAllCategoriasOrderByNombreCategoriaListForSelectInput(): Collection 
    {
       return Categoria::pluck('nombre_categoria','id');
    }

}