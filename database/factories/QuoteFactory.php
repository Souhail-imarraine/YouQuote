<?php

namespace Database\Factories;

use app\Models\User;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Quote>
 */
class QuoteFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'user_id' => 5,
            'content' => $this->faker->paragraph(),
            'author' => $this->faker->sentence(),
            'popularity' => rand(1, 100),
        ];
    }
}
