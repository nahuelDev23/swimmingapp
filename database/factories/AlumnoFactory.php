<?php

namespace Database\Factories;

use App\Models\Alumno;
use Illuminate\Database\Eloquent\Factories\Factory;

class AlumnoFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Alumno::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'nombre' => $this->faker->name,
            'apellido'=> $this->faker->name,
            'categoria_id'=> 1,
            'club_id' => 1,
            'sexo' =>'F',
            'dni' => rand(1111111111,9999999999),
            'fecha_nacimiento' => '1991-10-23',
        ];
    }
}
