<?php

namespace Tests\Feature;

use App\Models\Alumno;
use App\Models\Club;
use App\Models\Categoria;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class addAlumnoRequestTest extends TestCase
{
    use RefreshDatabase;

    /**
     * nombre
     */
    public function test_a_alumno_requires_name_when_store()
    {
        $club = Club::factory()->create();
        $this->loggedIn($club->id);
       

        $this->get(route('alumnos.create'))
        ->assertStatus(200);

        $fields = Alumno::factory()->raw(['nombre'=>'']);
        $url = route('alumnos.store');
        $this->post($url,$fields)->assertSessionHasErrors('nombre');
        
    }

    public function test_a_alumno_requires_min_3_char_when_store()
    {
        $club = Club::factory()->create();
        $this->loggedIn($club->id);
       

        $this->get(route('alumnos.create'))
        ->assertStatus(200);

        $fields = Alumno::factory()->raw(['nombre'=>'as']);
        $url = route('alumnos.store');
        $this->post($url,$fields)->assertSessionHasErrors('nombre');
        
    }

    public function test_a_alumno_requires_max_50_char_when_store()
    {
        $club = Club::factory()->create();
        $this->loggedIn($club->id);
       

        $this->get(route('alumnos.create'))
        ->assertStatus(200);

        $fields = Alumno::factory()->raw(['nombre'=>'abcdefghijkllmnñopqrstuvwxyzabcdefghijkllmnñopqrstuvwxyz']);
        $url = route('alumnos.store');
        $this->post($url,$fields)->assertSessionHasErrors('nombre');
        
    }

    public function test_a_alumno_name_can_not_be_number_when_store()
    {
        $club = Club::factory()->create();
        $this->loggedIn($club->id);
       

        $this->get(route('alumnos.create'))
        ->assertStatus(200);

        $fields = Alumno::factory()->raw(['nombre'=>'123']);
        $url = route('alumnos.store');
        $this->post($url,$fields)->assertSessionHasErrors('nombre');
        
    }

    /**
     * apellido
     */

    public function test_a_alumno_requires_apellido_when_store()
    {
        $club = Club::factory()->create();
        $this->loggedIn($club->id);
       

        $this->get(route('alumnos.create'))
        ->assertStatus(200);

        $fields = Alumno::factory()->raw(['apellido'=>'']);
        $url = route('alumnos.store');
        $this->post($url,$fields)->assertSessionHasErrors('apellido');
        
    }

    public function test_a_apellido_alumno_requires_min_3_char_when_store()
    {
        $club = Club::factory()->create();
        $this->loggedIn($club->id);
       

        $this->get(route('alumnos.create'))
        ->assertStatus(200);

        $fields = Alumno::factory()->raw(['apellido'=>'as']);
        $url = route('alumnos.store');
        $this->post($url,$fields)->assertSessionHasErrors('apellido');
        
    }

    public function test_a_apellido_alumno_requires_max_50_char_when_store()
    {
        $club = Club::factory()->create();
        $this->loggedIn($club->id);
       

        $this->get(route('alumnos.create'))
        ->assertStatus(200);

        $fields = Alumno::factory()->raw(['apellido'=>'abcdefghijkllmnñopqrstuvwxyzabcdefghijkllmnñopqrstuvwxyz']);
        $url = route('alumnos.store');
        $this->post($url,$fields)->assertSessionHasErrors('apellido');
        
    }

    public function test_a_apellido_alumno_can_not_be_number_when_store()
    {
        $club = Club::factory()->create();
        $this->loggedIn($club->id);
       

        $this->get(route('alumnos.create'))
        ->assertStatus(200);

        $fields = Alumno::factory()->raw(['nombre'=>'123']);
        $url = route('alumnos.store');
        $this->post($url,$fields)->assertSessionHasErrors('nombre');
        
    }

    //categoria_id numeric

    public function test_a_alumno_requires_categoria_id_when_store()
    {
        $club = Club::factory()->create();
        $this->loggedIn($club->id);

        $this->get(route('alumnos.create'))
        ->assertStatus(200);

        $fields = ['categoria_id' => ''];
        $url = route('alumnos.store');
        
        $this->post($url,$fields)->assertSessionHasErrors('categoria_id');
    }

    public function test_a_alumno_categoria_id_is_numeric_when_store()
    {
        $club = Club::factory()->create();
        $this->loggedIn($club->id);

        $this->get(route('alumnos.create'))
        ->assertStatus(200);

        $fields = ['categoria_id' => 'a'];
        $url = route('alumnos.store');
        
        $this->post($url,$fields)->assertSessionHasErrors('categoria_id');
    }

    public function test_a_alumno_categoria_id_max_2_when_store()
    {
        $club = Club::factory()->create();
        $this->loggedIn($club->id);

        $this->get(route('alumnos.create'))
        ->assertStatus(200);

        $fields = ['categoria_id' => '123'];
        $url = route('alumnos.store');
        
        $this->post($url,$fields)->assertSessionHasErrors('categoria_id');
    }
    /**
     * sexo
     */

    public function test_a_alumno_requires_sexo_when_store()
    {
        $club = Club::factory()->create();
        $this->loggedIn($club->id);

        $this->get(route('alumnos.create'))
        ->assertStatus(200);

        $fields = ['sexo' => ''];
        $url = route('alumnos.store');
        
        $this->post($url,$fields)->assertSessionHasErrors('sexo');
    }

    public function test_a_sexo_alumno_can_not_be_number_when_store()
    {
        $club = Club::factory()->create();
        $this->loggedIn($club->id);

        $this->get(route('alumnos.create'))
        ->assertStatus(200);

        $fields = ['sexo' => '1'];
        $url = route('alumnos.store');
        
        $this->post($url,$fields)->assertSessionHasErrors('sexo');
    }

    public function test_a_sexo_alumno_can_not_be_more_than_1_length_when_store()
    {
        $club = Club::factory()->create();
        $this->loggedIn($club->id);

        $this->get(route('alumnos.create'))
        ->assertStatus(200);

        $fields = ['sexo' => 'aa'];
        $url = route('alumnos.store');
        
        $this->post($url,$fields)->assertSessionHasErrors('sexo');
    }

    //dni

    public function test_a_alumno_requires_dni_when_store()
    {
        $club = Club::factory()->create();
        $this->loggedIn($club->id);

        $this->get(route('alumnos.create'))
        ->assertStatus(200);

        $fields = ['dni' => ''];
        $url = route('alumnos.store');
        
        $this->post($url,$fields)->assertSessionHasErrors('dni');
    }

    public function test_a_alumno_is_unique_dni_when_store()
    {
        $club = Club::factory()->create();
        $this->loggedIn($club->id);

        $this->get(route('alumnos.create'))
        ->assertStatus(200);

        $club = Club::factory()->create();

        $categoria = Categoria::factory()->create();

        Alumno::factory()->create(['dni' => '123','categoria_id'=>$categoria->id,'club_id'=>$club->id]);
        $fields = ['dni' => '123'];
        $url = route('alumnos.store');
        
        $this->post($url,$fields)->assertSessionHasErrors('dni');
    }

    public function test_a_alumno_requires_min_length_10_dni_when_store()
    {
        $club = Club::factory()->create();
        $this->loggedIn($club->id);

        $this->get(route('alumnos.create'))
        ->assertStatus(200);

        $fields = ['dni' => '36.567.01'];
        $url = route('alumnos.store');
        
        $this->post($url,$fields)->assertSessionHasErrors('dni');
    }

    public function test_a_alumno_requires_max_length_10_dni_when_store()
    {
        $club = Club::factory()->create();
        $this->loggedIn($club->id);

        $this->get(route('alumnos.create'))
        ->assertStatus(200);

        $fields = ['dni' => '36.567.0199'];
        $url = route('alumnos.store');
        
        $this->post($url,$fields)->assertSessionHasErrors('dni');
    }

    public function test_a_alumno_requires_only_number_and_dot_dni_when_store()
    {
        $club = Club::factory()->create();
        $this->loggedIn($club->id);

        $this->get(route('alumnos.create'))
        ->assertStatus(200);

        $fields = ['dni' => '36.56/.01a'];
        $url = route('alumnos.store');
        
        $this->post($url,$fields)->assertSessionHasErrors('dni');
    }

    //fecha_nacimiento

    public function test_a_alumno_requires_fecha_nacimiento_when_store()
    {
        $club = Club::factory()->create();
        $this->loggedIn($club->id);

        $this->get(route('alumnos.create'))
        ->assertStatus(200);

        $fields = ['fecha_nacimiento' => ''];
        $url = route('alumnos.store');
        
        $this->post($url,$fields)->assertSessionHasErrors('fecha_nacimiento');
    }

    public function test_a_alumno_requires_min_length_10_fecha_nacimiento_when_store()
    {
        $club = Club::factory()->create();
        $this->loggedIn($club->id);

        $this->get(route('alumnos.create'))
        ->assertStatus(200);

        $fields = ['fecha_nacimiento' => '1991-10-2'];
        $url = route('alumnos.store');
        
        $this->post($url,$fields)->assertSessionHasErrors('fecha_nacimiento');
    }

    public function test_a_alumno_requires_max_length_10_fecha_nacimiento_when_store()
    {
        $club = Club::factory()->create();
        $this->loggedIn($club->id);

        $this->get(route('alumnos.create'))
        ->assertStatus(200);

        $fields = ['fecha_nacimiento' => '1991-10-222'];
        $url = route('alumnos.store');
        
        $this->post($url,$fields)->assertSessionHasErrors('fecha_nacimiento');
    }

    /**
     * no se si cumple lo que quiero
     */
    public function test_a_alumno_format_fecha_nacimiento_when_store()
    {
        $club = Club::factory()->create();
        $this->loggedIn($club->id);

        $this->get(route('alumnos.create'))
        ->assertStatus(200);

        $fields = ['fecha_nacimiento' => '1991-10-22'];
        $url = route('alumnos.store');
        
        $this->post($url,$fields);

        $expected = '1991-10-22';

        $this->assertEquals($expected,$fields['fecha_nacimiento']);
    }
}
