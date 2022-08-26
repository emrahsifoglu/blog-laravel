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
   * @return AnonymousResourceCollection
   */
    public function index(): AnonymousResourceCollection
    {
      $posts = $this->repository->findAll();

      return PostResource::collection($posts);
    }

    /**
     * Store a newly created resource in storage.
     *
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
     * @param string $id
     * @return JsonResponse
     */
    public function show(string $id)
    {
      $post = $this->repository->findById($id);

      return response()->json((new PostResource($post))->withAuthor()->withComments(), Response::HTTP_OK);
    }
}
