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
     * @OA\Get (
     *     tags={"Posts"},
     *     path="/api/admin/posts/{postId}",
     *     operationId="GetPostForAdmin",
     *     tags={"Posts"},
     *     summary="Get Post For Admin",
     *     description="Get Post For Admin",
     *     security={{"bearerAuth":{ }}},
     *     @OA\Parameter(
     *        description="ID of Post",
     *        in="path",
     *        name="postId",
     *        required=true,
     *        example="123e4567-e89b-12d3-a456-426614174000",
     *        @OA\Schema(
     *           type="strind",
     *           format="uuid"
     *        )
     *     ),
     *     @OA\Response(response="200", description="Show", @OA\JsonContent())
     * )
     * @param string $id
     * @return JsonResponse
     */
    public function show(string $id): JsonResponse
    {
      $post = $this->repository->findDeletedById($id);

      return response()->json((new PostResource($post))->withAuthor()->withComments(), Response::HTTP_OK);
    }

    /**
     * @OA\Delete (
     *     tags={"Posts"},
     *     path="/api/admin/posts/{postId}",
     *     operationId="DeletePostByAdmin",
     *     tags={"Posts"},
     *     summary="Delete Post By Admin",
     *     description="Delete Post By Admin",
     *     security={{"bearerAuth":{ }}},
     *     @OA\Parameter(
     *        description="ID of Post",
     *        in="path",
     *        name="postId",
     *        required=true,
     *        example="123e4567-e89b-12d3-a456-426614174000",
     *        @OA\Schema(
     *           type="strind",
     *           format="uuid"
     *        )
     *     ),
     *     @OA\Response(response="204", description="Delete", @OA\JsonContent())
     * )
     * @param string $id
     * @return JsonResponse
     */
    public function delete(string $id): JsonResponse
    {
      $this->repository->delete($id);

      return response()->json([], Response::HTTP_NO_CONTENT);
    }

    /**
     * @OA\Post  (
     *     tags={"Posts"},
     *     path="/api/admin/posts/{postId}/restore",
     *     operationId="RestorePostByAdmin",
     *     tags={"Posts"},
     *     summary="Restore Post By Admin",
     *     description="Restore Post By Admin",
     *     security={{"bearerAuth":{ }}},
     *     @OA\Parameter(
     *        description="ID of Post",
     *        in="path",
     *        name="postId",
     *        required=true,
     *        example="123e4567-e89b-12d3-a456-426614174000",
     *        @OA\Schema(
     *           type="strind",
     *           format="uuid"
     *        )
     *     ),
     *     @OA\Response(response="200", description="Restore", @OA\JsonContent())
     * )
     * @param string $id
     * @return JsonResponse
     */
    public function restore(string $id): JsonResponse
    {
      $this->repository->restore($id);

      return response()->json([], Response::HTTP_OK);
    }
}
