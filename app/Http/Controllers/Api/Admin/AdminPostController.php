<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Controller;
use App\Http\Resources\PostResource;
use App\Repositories\PostRepository;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;

class AdminPostController extends Controller
{
    /** @var PostRepository  */
    private PostRepository $repository;

    /**
     * @param PostRepository $repository
     */
    public function __construct(PostRepository $repository)
    {
      $this->repository = $repository;
    }

    /**
     * @param string $id
     * @return JsonResponse
     */
    public function show(string $id): JsonResponse
    {
      $post = $this->repository->findDeletedById($id);

      return response()->json((new PostResource($post))->withAuthor()->withComments(), Response::HTTP_OK);
    }

    /**
     * @param string $postId
     * @return JsonResponse
     */
    public function delete(string $postId): JsonResponse
    {
      $this->repository->delete($postId);

      return response()->json([], Response::HTTP_NO_CONTENT);
    }

    /**
     * @param string $postId
     * @return JsonResponse
     */
    public function restore(string $postId): JsonResponse
    {
      $this->repository->restore($postId);

      return response()->json([], Response::HTTP_NO_CONTENT);
    }
}
