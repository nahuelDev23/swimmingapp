<?php

namespace Database\Factories;

use App\Models\Cancheo;
use Illuminate\Database\Eloquent\Factories\Factory;

class CancheoFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Cancheo::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'carril' => rand(1,5),
            'competidor_id'=>1,
            'serie_id'=>1,
            'competencia_id'=>1,
            'tiempo' => time(),
        ];
    }
}
