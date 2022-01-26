<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class TaskFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'title' => ucfirst($this->faker->word()) . ' ' . $this->faker->word() . ' ' . $this->faker->word(),
            'status' => $this->faker->boolean(),
            'list_id' => $this->faker->numberBetween(1, 10)
        ];
    }
}
