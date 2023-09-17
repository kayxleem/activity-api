<?php

namespace Database\Factories;

use App\Models\Activity;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\UserActivity>
 */
class UserActivityFactory extends Factory
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
            'user_id' => function(){
                return User::factory()->create()->id;
            },
            'activity_id' => function(){
                return Activity::factory()->create([
                    'scope' => 'local'
                ])->id;
            },

        ];
    }
}
