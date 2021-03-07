<?php

namespace Tests\Unit;

use App\Models\Alumno;
use App\Models\Categoria;
use App\Models\Club;
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Repositories\UsesCase\Alumno\Create;

class AlumnoCreateTest extends TestCase
{
    use RefreshDatabase;

    public function test_alumno_create()
    {
        // $this->withoutExceptionHandling();
        $club = Club::factory()->make();
        $this->loggedIn($club->id);
        
        $categoria = Categoria::factory()->make();
        $request = Alumno::factory()->make(['categoria_id'=>$categoria->id,'club_id'=>$club->id]);
        
        $create = new Create();
        $create->execute($request);
         
        $this->assertDatabaseHas('alumnos',$request->toArray());

        // fwrite(STDERR, print_r( $request, TRUE));
    }
}
