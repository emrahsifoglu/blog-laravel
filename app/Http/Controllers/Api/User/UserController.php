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
     * @param UserRegisterRequest $request
     * @return JsonResponse
     */
    public function create(UserRegisterRequest $request): JsonResponse
    {
      $user = $this->repository->store($request->all());

      return response()->json(new UserResource($user),  Response::HTTP_CREATED);
    }
}
