<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Post>
 */
class PostFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'post_number' => 1,
            'created_by' => User::all()->random()->id,
            'name' => $this->faker->sentence(14),
            'content' => $this->faker->paragraphs(4, true),
            'version' => 1,
            'is_active' => true
        ];
    }
}
