<?php

namespace Database\Factories;

use App\Models\APIMethod;
use Illuminate\Database\Eloquent\Factories\Factory;

class APIMethodFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = APIMethod::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'api_id' => \App\Models\Api::factory(), // Esto creará una nueva instancia de Api cuando se use el factory de APIMethod.
            'name' => $this->faker->word,
            'documentation' => $this->faker->sentence,
            'url' => $this->faker->url,
        ];
    }
}

