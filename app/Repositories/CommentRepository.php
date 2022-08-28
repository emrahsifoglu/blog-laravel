<?php

namespace App\Repositories;

use App\Models\Comment;
use Illuminate\Support\Collection;
use Illuminate\Support\Str;

class CommentRepository
{
    /**
     * @param array $parameters
     * @param string $postId
     * @param string $userId
     * @return Comment
     */
    public function store(array $parameters, string $postId, string $userId): Comment
    {
      $parameters['id'] = Str::uuid();
      $parameters['post_id'] = $postId;
      $parameters['commenter_id'] = $userId;

      $comment = new Comment($parameters);
      $comment->save();

      return $comment->fresh();
    }

    /**
     * @param string $postId
     * @param string $id
     * @return Comment
     */
    public function findById(string $postId, string $id): Comment
    {
      /** @var Comment $comment */
      $comment = Comment::query()
        ->join('posts','posts.id','=','comments.post_id')
        ->where('comments.post_id', '=', $postId)
        ->where('comments.id', '=', $id)
        ->whereNull('posts.deleted_at')
        ->firstOrFail();

      return $comment;
    }

    /**
     * @param string $postId
     * @return Collection
     */
    public function findAllBelongToPost(string $postId): Collection
    {
      return Comment::query()
        ->join('posts','posts.id','=','comments.post_id')
        ->where('comments.post_id', '=', $postId)
        ->whereNull('posts.deleted_at')
        ->select('comments.*')
        ->get();
    }
}
