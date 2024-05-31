<?php

namespace Database\Factories;

use App\Enums\UserPostAction;
use App\Models\Post;
use App\Models\User;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\UserPostAction>
 */
class UserPostActionFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'id_user' => User::all()->random()->id,
            'id_post' => Post::all()->random()->id,
            'action' =>  UserPostAction::ACTION_CREATED
        ];
    }
}
