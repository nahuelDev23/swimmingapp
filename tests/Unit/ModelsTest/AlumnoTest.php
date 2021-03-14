<?php

namespace Tests\Unit\ModelsTest;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Models\Alumno;
use App\Models\Categoria;
use App\Models\Club;
use App\Models\Competencia;
use App\Models\Competidor;
use App\Models\Prueba;
use Illuminate\Database\Eloquent\Collection;


class AlumnoTest extends TestCase
{
   use RefreshDatabase;

    public function test_belongs_to_a_categoria()
    {
        $categoria = Categoria::factory()->create();

        $alumnos = Alumno::factory()->make(['categoria_id'=>$categoria->id]);

        $this->assertInstanceOf(Categoria::class, $alumnos->categoria);
    }

    public function test_has_many_competidores()
    {
      
        $competencia = Competencia::factory()->create([
            'nombre_competencia'=>'kaakak',
            'detalle'=>'kaakak',
            'fecha_competencia'=>'2019-10-20',
            'carriles'=>5,
            'estado'=>1,
            ]);
            
        $categoria = Categoria::factory()->create();
        $prueba  = Prueba::factory()->create([
            'competencia_id'=>$competencia->id,
            'categoria_id'=>$categoria->id
            ]);

        
        
        $alumnos = Alumno::factory()->make(['categoria_id'=>$categoria->id]);

        $competidores = Competidor::factory()->create([
            'prueba_id'=>$prueba->id,
            'competencia_id'=>$competencia->id
            ]);
        

        $this->assertInstanceOf(Collection::class, $alumnos->competidores);
    }

}
