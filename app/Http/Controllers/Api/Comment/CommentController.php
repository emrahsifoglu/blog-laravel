<?php

namespace App\Http\Controllers\Api\Comment;

use App\Http\Controllers\Controller;
use App\Http\Requests\Comment\CommentStoreRequest;
use App\Http\Resources\CommentResource;
use App\Repositories\CommentRepository;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Illuminate\Http\Response;

class CommentController extends Controller
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
     * @return AnonymousResourceCollection
     */
    public function index(string $postId): AnonymousResourceCollection
    {
      $comments = $this->repository->findAllBelongToPost($postId);

      return CommentResource::collection($comments);
    }

    /**
     * @param CommentStoreRequest $request
     * @param string $postId
     * @return JsonResponse
     */
    public function store(CommentStoreRequest $request, string $postId): JsonResponse
    {
      $userId = auth()->id();

      $comment = $this->repository->store($request->all(), $postId, $userId);

      return response()->json((new CommentResource($comment))->withCommenter(), Response::HTTP_CREATED);
    }

    /**
     * @param string $postId
     * @param string $id
     * @return JsonResponse
     */
    public function show(string $postId, string $id): JsonResponse
    {
      $comment = $this->repository->findById($postId, $id);

      return response()->json((new CommentResource($comment))->withCommenter(), Response::HTTP_OK);
    }
}
