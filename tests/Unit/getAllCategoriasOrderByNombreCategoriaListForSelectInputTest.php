<?php

namespace Tests\Unit;
use Tests\TestCase;
use App\Models\Categoria;
use App\Repositories\UsesCase\Categoria\getAllCategoriasOrderByNombreCategoriaListForSelectInput;
use Illuminate\Foundation\Testing\RefreshDatabase;

class getAllCategoriasOrderByNombreCategoriaListForSelectInputTest extends TestCase
{
    USE RefreshDatabase;
    
    public function test_example()
    {
        $categoria = Categoria::factory()->create();
        $categoria = Categoria::factory()->create();
        $categoria = Categoria::factory()->create();

        $categorias_list = new getAllCategoriasOrderByNombreCategoriaListForSelectInput();
        $data = $categorias_list->execute();

        $this->assertEquals(3,count($data));
        $this->assertArrayHasKey('1',$data->toArray());
        $this->assertContains($categoria->nombre_categoria,$data);

         
        // fwrite(STDERR, print_r( $categoria->nombre_categoria, TRUE));
    }
}
