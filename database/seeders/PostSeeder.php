<?php

namespace Database\Seeders;

use App\Models\Comment;
use App\Models\Post;
use App\Models\User;
use Illuminate\Database\Seeder;

class PostSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        /** @var User $author */
        $author = User::factory()->create();

        /** @var Post $post */
        $post = Post::factory()->withAuthor($author->id)->create();

        /** @var User $commenter */
        $commenter = User::factory()->create();

        Comment::factory()->count(2)
          ->withCommenter($commenter->id)
          ->withPost($post->id)->create();
    }
}
