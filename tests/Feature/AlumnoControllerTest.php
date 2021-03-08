<?php

namespace Tests\Feature;

use App\Models\Alumno;
use App\Models\Club;
use App\Models\User;
use App\Models\Categoria;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use App\Repositories\UsesCase\Alumno\Create;
use Tests\TestCase;
use Maatwebsite\Excel\Facades\Excel;
use App\Imports\AlumnosImport;

class AlumnoControllerTest extends TestCase
{
    use RefreshDatabase;

    public function test_a_loggin_user_can_access_in_alumnos_index()
    {
        $club = Club::factory()->create();
        $this->loggedIn($club->id);
        $this->get(route('alumnos.index'))
            ->assertStatus(200)
            ->assertViewHas('alumnos');
    }
    public function test_a_unloggin_user_can_not_access_in_alumnos_index()
    {
        $this->get(route('alumnos.index'))
            ->assertRedirect('login');
    }

    public function test_a_unloggin_user_can_not_access_in_alumnos_create()
    {
        $this->get(route('alumnos.create'))
            ->assertRedirect('login');
    }

    public function test_a_loggin_user_can_access_in_alumnos_create()
    {
        $club = Club::factory()->create();
        $this->loggedIn($club->id);
        $this->get(route('alumnos.create'))
            ->assertStatus(200)
            ->assertViewHas('categorias')
            ->assertViewHas('clubs');
    }

    public function test_a_loggin_user_can_save_alumnos_store()
    {
        $club = Club::factory()->create();
        $this->loggedIn($club->id);

        $this->get(route('alumnos.create'))
            ->assertStatus(200)
            ->assertViewHas('categorias')
            ->assertViewHas('clubs');

            $fields = Alumno::factory()->raw();
            
            $url = route('alumnos.store');
            $response = $this->post($url,$fields); //store

            $response->assertStatus(302);
           
    }

    public function test_a_loggin_user_can_see_alumnos_edit()
    {
        $club = Club::factory()->create();
        $this->loggedIn($club->id);

        $categoria = Categoria::factory()->create();
        $alumno =Alumno::factory()->create(['categoria_id'=>$categoria->id,'club_id'=>$club->id]);

        $this->get(route('alumnos.edit',$alumno->id))
            ->assertStatus(200)
            ->assertViewHas('alumno')
            ->assertSee($alumno->nombre);

           
    }

    public function test_a_loggin_user_can_alumnos_update()
    {
        // $this->withoutExceptionHandling();

        $club = Club::factory()->create();
        $this->loggedIn($club->id);

        $categoria = Categoria::factory()->create();
        $alumno =Alumno::factory()->create(['categoria_id'=>$categoria->id,'club_id'=>$club->id]);

        $this->get(route('alumnos.edit',$alumno->id))
            ->assertStatus(200)
            ->assertViewHas('alumno')
            ->assertSee($alumno->nombre);

        $fields = [
            'nombre' => 'jaime de los santos',
            'apellido' => 'mileno',
            'categoria_id' => '1',
            'sexo' => 'm',
            'dni' => '36.546.777',
            'fecha_nacimiento' => '1991-10-20',
        ];
  
        $this->patch(route('alumnos.update',$alumno->id),$fields);
        $this->assertDatabaseHas('alumnos',['nombre' => 'jaime de los santos']);
        // fwrite(STDERR, print_r($fields, TRUE));
    }

    public function test_a_loggin_user_can_alumnos_delete()
    {
        $this->withoutExceptionHandling();

        $club = Club::factory()->create();
        $this->loggedIn($club->id);
        Categoria::factory()->create();
        $alumno = Alumno::factory()->create();
       
        $this->get(route('alumnos.index'))
            ->assertStatus(200)
            ->assertViewHas('alumnos');

       
        $this->delete(route('alumnos.destroy',$alumno->id));

        $this->assertDatabaseMissing('alumnos',['id'=>$alumno->id]);
        // fwrite(STDERR, print_r($user, TRUE));
    }

    public function test_a_loggin_user_can_not_alumnos_delete_if_is_not_my_club()
    {
        // $this->withoutExceptionHandling();

        $club = Club::factory()->create();
        $club2 = Club::factory()->create();
        $this->loggedIn($club->id);

        $categoria = Categoria::factory()->create();

        $alumno =Alumno::factory()->create(['categoria_id'=>$categoria->id,'club_id'=>$club->id]);
        $alumno2 =Alumno::factory()->create(['categoria_id'=>$categoria->id,'club_id'=>$club2->id]);

        $this->get(route('alumnos.index'))
            ->assertStatus(200)
            ->assertViewHas('alumnos');

        $response = $this->delete(route('alumnos.destroy',$alumno2->id));
        $response->assertStatus(403);
        // fwrite(STDERR, print_r($alumno, TRUE));
    }

   
}
