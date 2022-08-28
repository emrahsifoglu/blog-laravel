<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

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
    public function definition()
    {
        return [
          'id' => Str::uuid(),
          'title' => fake()->title,
          'description' => fake()->text
        ];
    }

    /**
     * @param string $id
     * @return PostFactory
     */
    public function withAuthor(string $id): PostFactory
    {
        return $this->state([
          'author_id' => $id
        ]);
    }
}
