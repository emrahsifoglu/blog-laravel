<?php

namespace App\Http\Controllers\Api\Post;

use App\Http\Controllers\Controller;
use App\Http\Requests\Post\PostStoreRequest;
use App\Http\Resources\PostResource;
use App\Repositories\PostRepository;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Illuminate\Http\Response;

class PostController extends Controller
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
     * @OA\Get (
     *     tags={"Posts"},
     *     path="/api/posts",
     *     operationId="GetAllPosts",
     *     tags={"Posts"},
     *     summary="Get all posts",
     *     description="Get all posts",
     *     security={{"bearerAuth":{ }}},
     *     @OA\Response(response="200", description="Index", @OA\JsonContent())
     * )
     * @return AnonymousResourceCollection
     */
    public function index(): AnonymousResourceCollection
    {
      $posts = $this->repository->findAll();

      return PostResource::collection($posts);
    }

    /**
     * @OA\Post(
     *     tags={"Posts"},
     *     path="/api/posts",
     *     operationId="CreatePost",
     *     summary="Create Post",
     *     description="Create Post here",
     *     security={{"bearerAuth":{ }}},
     *     @OA\RequestBody(
     *        description="create a post",
     *        required=true,
     *        @OA\MediaType(
     *           mediaType="application/json",
     *           @OA\Schema(
     *              type="object",
     *              required={"title", "description"},
     *              example={
     *                 "title": "example title",
     *                 "description": "example description"
     *              },
     *              @OA\Property(property="title", type="text"),
     *              @OA\Property(property="description", type="text"),
     *           ),
     *        ),
     *     ),
     *     @OA\Response(response="201", description="Registered", @OA\JsonContent()),
     *     @OA\Response(response="422", description="Unprocessable Entity", @OA\JsonContent()),
     * )
     * @param PostStoreRequest $request
     * @return JsonResponse
     */
    public function store(PostStoreRequest $request): JsonResponse
    {
        $userId = auth()->id();

        $post = $this->repository->store($request->all(), $userId);

        return response()->json((new PostResource($post))->withAuthor()->withComments(), Response::HTTP_CREATED);
    }

    /**
     * @OA\Get (
     *     tags={"Posts"},
     *     path="/api/posts/{postId}",
     *     operationId="GetPost",
     *     summary="Get Post",
     *     description="Get Post",
     *     security={{"bearerAuth":{ }}},
     *     @OA\Response(response="200", description="Show", @OA\JsonContent())
     * )
     * @param string $id
     * @return JsonResponse
     */
    public function show(string $id): JsonResponse
    {
      $post = $this->repository->findById($id);

      return response()->json((new PostResource($post))->withAuthor()->withComments(), Response::HTTP_OK);
    }
}
