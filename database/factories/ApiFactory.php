<?php

namespace Database\Factories;

use App\Models\API;
use Illuminate\Database\Eloquent\Factories\Factory;

class ApiFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = API::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'name' => $this->faker->word,
            'base_url' => $this->faker->url,
            // Asegúrate de incluir todos los campos obligatorios del modelo aquí
        ];
    }
}

