<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Activity>
 */
class ActivityFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'title' => fake()->sentence,
            'description' => fake()->paragraph,
            'image' => fake()->imageUrl(),
            'activity_date' => fake()->dateTime(),
        ];
    }

    public function userScope()
    {
        return $this->state(function () {
            return [
                'scope' => 'user'
            ];
        });
    }
}
