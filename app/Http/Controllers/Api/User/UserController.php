<?php

namespace App\Http\Controllers\Api\User;

use App\Http\Controllers\Controller;
use App\Http\Requests\User\UserRegisterRequest;
use App\Http\Resources\UserResource;
use App\Repositories\UserRepository;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;

class UserController extends Controller
{
    /** @var UserRepository  */
    private UserRepository $repository;

    /**
    * @param UserRepository $repository
    */
    public function __construct(UserRepository $repository)
    {
      $this->repository = $repository;
    }

    /**
     * @OA\Post(
     *     tags={"Users"},
     *     path="/api/register",
     *     operationId="Register",
     *     summary="User Register",
     *     description="User Register here",
     *     @OA\RequestBody(
     *        description="register a user",
     *        required=true,
     *        @OA\MediaType(
     *           mediaType="application/json",
     *           @OA\Schema(
     *              type="object",
     *              required={"name", "surname", "phone", "email", "password", "passwordRepeat"},
     *              example={
     *                 "name": "johnny",
     *                 "surname": "Depp",
     *                 "phone": "phone",
     *                 "email": "j.depp@example.com",
     *                 "password": "password",
     *                 "passwordRepeat": "password"
     *              },
     *              @OA\Property(property="name", type="text"),
     *              @OA\Property(property="surname", type="text"),
     *              @OA\Property(property="phone", type="text"),
     *              @OA\Property(property="email", type="text"),
     *              @OA\Property(property="password", type="password"),
     *              @OA\Property(property="passwordRepeat", type="password")
     *           ),
     *        ),
     *     ),
     *     @OA\Response(response="201", description="Registered", @OA\JsonContent()),
     *     @OA\Response(response="422", description="Unprocessable Entity", @OA\JsonContent()),
     * )
     * @param UserRegisterRequest $request
     * @return JsonResponse
     */
    public function create(UserRegisterRequest $request): JsonResponse
    {
      $user = $this->repository->store($request->all());

      return response()->json(new UserResource($user),  Response::HTTP_CREATED);
    }
}
