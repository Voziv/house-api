<?php

namespace Database\Factories;

use App\Models\Room;
use App\Models\Temperature;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class TemperatureFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Temperature::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'temperature' => $this->faker->numberBetween(10, 20),
            'humidity' => $this->faker->numberBetween(30, 60),
        ];
    }
}
