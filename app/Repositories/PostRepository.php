<?php

namespace App\Repositories;

use App\Models\Post;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Str;

class PostRepository
{
    /**
     * @return Collection
     */
    public function findAll(): Collection
    {
      return Post::all();
    }

    /**
     * @param array $parameters
     * @param string $authorId
     * @return Post
     */
    public function store(array $parameters, string $authorId): Post
    {
      $parameters['id'] = Str::uuid();
      $parameters['author_id'] = $authorId;

      $post = new Post($parameters);
      $post->save();

      return $post->fresh();
    }

    /**
     * @param string $id
     * @return Post
     */
    public function findById(string $id): Post
    {
      /** @var Post $post */
      $post = Post::query()
        ->where('id', '=', $id)
        ->firstOrFail();

      return $post;
    }
}