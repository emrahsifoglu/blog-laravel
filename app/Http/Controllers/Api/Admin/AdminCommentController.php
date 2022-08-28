<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Controller;
use App\Http\Resources\CommentResource;
use App\Repositories\CommentRepository;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;

class AdminCommentController extends Controller
{
    /** @var CommentRepository  */
    private CommentRepository $repository;

    /**
     * @param CommentRepository $repository
     */
    public function __construct(CommentRepository $repository)
    {
      $this->repository = $repository;
    }

    /**
     * @param string $postId
     * @param string $id
     * @return JsonResponse
     */
    public function show(string $postId, string $id): JsonResponse
    {
      $comment = $this->repository->findDeletedById($postId, $id);

      return response()->json((new CommentResource($comment))->withCommenter(), Response::HTTP_OK);
    }

    /**
     * @param string $postId
     * @param string $id
     * @return JsonResponse
     */
    public function delete(string $postId, string $id): JsonResponse
    {
      $this->repository->delete($postId, $id);

      return response()->json([], Response::HTTP_NO_CONTENT);
    }

    /**
     * @param string $postId
     * @param string $id
     * @return JsonResponse
     */
    public function restore(string $postId, string $id): JsonResponse
    {
      $this->repository->restore($postId, $id);

      return response()->json([], Response::HTTP_NO_CONTENT);
    }
}
