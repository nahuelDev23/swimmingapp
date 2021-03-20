<?php

namespace Tests\Unit\ModelsTest;

use App\Models\Serie;
use App\Models\Cancheo;
use App\Models\Competencia;
use App\Models\Competidor;
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
class CancheoTest extends TestCase
{
    use RefreshDatabase;

    public function test_belongs_to_a_serie()
    {
        Serie::factory()->create();
        $cancheo = Cancheo::factory()->make(['tiempo'=>'23:23:23']);
        $this->assertInstanceOf(Serie::class,$cancheo->serie);
    }

    public function test_belongs_to_a_competidor()
    {
        Competidor::factory()->create();
        $cancheo = Cancheo::factory()->make(['tiempo'=>'23:23:23']);
        $this->assertInstanceOf(Competidor::class,$cancheo->competidor);
    }

    public function test_belongs_to_a_competencia()
    {
        Competencia::factory()->create();
        $cancheo = Cancheo::factory()->make(['tiempo'=>'23:23:23']);
        $this->assertInstanceOf(Competencia::class,$cancheo->competencia);
    }
}
