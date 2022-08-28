<?php

namespace App\Repositories;

use App\Models\Post;
use Carbon\Carbon;
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

    /**
     * @param string $id
     * @return Post
     */
    public function findDeletedById(string $id): Post
    {
      /** @var Post $post */
      $post = Post::withTrashed()->newQuery()
        ->where('id', '=', $id)
        ->firstOrFail();

      return $post;
    }

    /**
     * @param string $id
     * @return mixed
     */
    public function delete(string $id): mixed
    {
      /** @var Post $address */
      return Post::query()
        ->where('id', '=', $id)
        ->firstOrFail()
        ->delete();
    }

    /**
     * @param int $hours
     * @return mixed
     */
    public function deleteAllOutDated(int $hours = 3): mixed
    {
      return Post::query()
        ->where('created_at', '<=', Carbon::now()->subHours($hours))
        ->delete();
    }

    /**
     * @param string $id
     * @return bool|null
     */
    public function restore(string $id): ?bool
    {
      return $this->findDeletedById($id)->restore();
    }
}
