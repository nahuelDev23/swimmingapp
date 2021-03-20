<?php

namespace Tests\Unit\ModelsTest;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Models\Alumno;
use App\Models\Categoria;
use App\Models\Club;

use Illuminate\Database\Eloquent\Collection;


class AlumnoTest extends TestCase
{
    use RefreshDatabase;

    public function test_belongs_to_a_categoria()
    {
        $categoria = Categoria::factory()->create();

        $alumnos = Alumno::factory()->make(['categoria_id' => $categoria->id]);

        $this->assertInstanceOf(Categoria::class, $alumnos->categoria);
    }

    public function test_has_many_competidores()
    {

        $categoria = Categoria::factory()->create();

        $alumnos = Alumno::factory()->make(['categoria_id' => $categoria->id]);

        $this->assertInstanceOf(Collection::class, $alumnos->competidores);
    }
    
    public function test_belongs_to_a_club()
    {
        Club::factory()->create();

        $categoria = Categoria::factory()->create();
       

        $alumnos = Alumno::factory()->make(['categoria_id'=>$categoria->id]);

    
        $this->assertInstanceOf(Club::class,$alumnos->club);
        
    }
}
