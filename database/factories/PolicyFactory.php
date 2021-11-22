<?php

namespace Database\Factories;

use App\Models\Policia;
use Illuminate\Database\Eloquent\Factories\Factory;

class PolicyFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Policia::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'cedula' => $this->faker->randomNumber(10),
            'apellido_paterno' => $this->faker->lastName,
            'apellido_materno' => $this->faker->lastName,
            'nombres' => $this->faker->firstName,
            'celular' => $this->faker->e164PhoneNumber,
            'convencional' => $this->faker->e164PhoneNumber,
            'correo' => $this->faker->freeEmail,
            'direccion_domicilio' => $this->faker->address,
            'estado' => 'a'

        ];
    }
}
