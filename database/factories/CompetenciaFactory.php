<?php

namespace Database\Factories;

use App\Models\Competencia;
use Illuminate\Database\Eloquent\Factories\Factory;

class CompetenciaFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Competencia::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'nombre_competencia'=>$this->faker->name,
            'fecha_competencia'=>$this->faker->date(),
            'detalle'=>$this->faker->text,
            'carriles'=>5,
            'estado'=> 1,
        ];
    }
}
