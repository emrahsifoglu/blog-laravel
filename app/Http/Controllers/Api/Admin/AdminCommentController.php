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
     * @OA\Get (
     *     tags={"Comments"},
     *     path="/api/admin/posts/{postId}/comments/{commentId}",
     *     operationId="GetCommentForAdmin",
     *     tags={"Comments"},
     *     summary="Get Comment For Admin",
     *     description="Get Comment For Admin",
     *     security={{"bearerAuth":{ }}},
     *     @OA\Response(response="200", description="Show", @OA\JsonContent())
     * )
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
     * @OA\Delete (
     *     tags={"Comments"},
     *     path="/api/admin/posts/{postId}/comments/{commentId}",
     *     operationId="DeleteCommentByAdmin",
     *     tags={"Comments"},
     *     summary="Delete Comment By Admin",
     *     description="Delete Comment By Admin",
     *     security={{"bearerAuth":{ }}},
     *     @OA\Response(response="204", description="Delete", @OA\JsonContent())
     * )
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
     * @OA\Post  (
     *     tags={"Comments"},
     *     path="/api/admin/posts/{postId}/comments/{commentId}/restore",
     *     operationId="RestoreCommentByAdmin",
     *     tags={"Comments"},
     *     summary="Restore Comment By Admin",
     *     description="Restore Comment By Admin",
     *     security={{"bearerAuth":{ }}},
     *     @OA\Response(response="200", description="Restore", @OA\JsonContent())
     * )
     * @param string $postId
     * @param string $id
     * @return JsonResponse
     */
    public function restore(string $postId, string $id): JsonResponse
    {
      $this->repository->restore($postId, $id);

      return response()->json([], Response::HTTP_OK);
    }
}
