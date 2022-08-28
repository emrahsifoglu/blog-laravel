<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Comment>
 */
class CommentFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
          'id' => Str::uuid(),
          'text' => fake()->text(255)
        ];
    }

    /**
     * @param string $id
     * @return CommentFactory
     */
    public function withCommenter(string $id): CommentFactory
    {
        return $this->state([
          'commenter_id' => $id
        ]);
    }

    /**
     * @param string $id
     * @return CommentFactory
     */
    public function withPost(string $id): CommentFactory
    {
        return $this->state([
          'post_id' => $id
        ]);
    }
}
