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
     * @OA\Get (
     *     tags={"Comments"},
     *     path="/api/posts/{postId}/comments",
     *     operationId="GetAllComments",
     *     summary="Get all commemts",
     *     description="Get all commemts",
     *     security={{"bearerAuth":{ }}},
     *     @OA\Response(response="200", description="Index", @OA\JsonContent())
     * )
     * @param string $postId
     * @return AnonymousResourceCollection
     */
    public function index(string $postId): AnonymousResourceCollection
    {
      $comments = $this->repository->findAllBelongToPost($postId);

      return CommentResource::collection($comments);
    }

    /**
     * @OA\Post(
     *     tags={"Comments"},
     *     path="/api/posts/{postId}/comments",
     *     operationId="CreateComment",
     *     summary="Create Comment",
     *     description="Create Post Comment",
     *     security={{"bearerAuth":{ }}},
     *     @OA\RequestBody(
     *        description="create a comment",
     *        required=true,
     *        @OA\MediaType(
     *           mediaType="application/json",
     *           @OA\Schema(
     *              type="object",
     *              required={"text"},
     *              example={
     *                 "text": "example comment"
     *              },
     *              @OA\Property(property="text", type="text"),
     *           ),
     *        ),
     *     ),
     *     @OA\Response(response="201", description="Registered", @OA\JsonContent()),
     *     @OA\Response(response="422", description="Unprocessable Entity", @OA\JsonContent()),
     * )
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
     * @OA\Get (
     *     tags={"Comments"},
     *     path="/api/posts/{postId}/comments/{commentId}",
     *     operationId="GetComment",
     *     summary="Get Comment",
     *     description="Get Comment",
     *     security={{"bearerAuth":{ }}},
     *     @OA\Response(response="200", description="Show", @OA\JsonContent())
     * )
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
