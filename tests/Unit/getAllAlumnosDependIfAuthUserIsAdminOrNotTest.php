<?php

namespace Tests\Unit;

use App\Models\Alumno;
use App\Models\Club;
use App\Repositories\UsesCase\Alumno\getAllAlumnosDependIfAuthUserIsAdminOrNot;
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Models\Categoria;

class getAllAlumnosDependIfAuthUserIsAdminOrNotTest extends TestCase
{
   
    use RefreshDatabase;
    
    public function test_get_all_alumnos_of_all_clubs_if_i_am_a_admin()
    {
        $this->withoutExceptionHandling();
        $this->loggedInAdmin();

        $club2 = Club::factory()->create();
        $club = Club::factory()->create();

        $categoria = Categoria::factory()->create();

        Alumno::factory()->create(['categoria_id'=>$categoria->id,'club_id'=>$club->id]);
        Alumno::factory()->create(['categoria_id'=>$categoria->id,'club_id'=>$club2->id]);


        $alumnos = new getAllAlumnosDependIfAuthUserIsAdminOrNot();
        $data = $alumnos->execute();


       $this->assertEquals(2,count($data));
    

        // fwrite(STDERR, print_r( $data, TRUE));
    }

    public function test_get_all_alumnos_of_my_club_if_i_am_not_a_admin()
    {
        $this->withoutExceptionHandling();
        $club = Club::factory()->create();
        $club2 = Club::factory()->create();

        $this->loggedIn($club->id);
        

        $categoria = Categoria::factory()->create();

        Alumno::factory()->create(['categoria_id'=>$categoria->id,'club_id'=>$club->id]);
        Alumno::factory()->create(['categoria_id'=>$categoria->id,'club_id'=>$club2->id]);


        $alumnos = new getAllAlumnosDependIfAuthUserIsAdminOrNot();
        $data = $alumnos->execute();


       $this->assertEquals(1,count($data));
    

        // fwrite(STDERR, print_r( $data, TRUE));
    }
}
