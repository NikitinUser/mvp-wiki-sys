<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Ramsey\Uuid\Uuid;

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
            'post_number' =>  Uuid::uuid4()->toString(),
            'created_by' => User::all()->random()->id,
            'title' => $this->faker->sentence(14),
            'content' => $this->faker->paragraphs(4, true),
            'version' => 1,
            'is_active' => true
        ];
    }
}
