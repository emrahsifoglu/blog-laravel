<?php

namespace App\Http\Controllers\Api\User;

use App\Http\Controllers\Controller;
use App\Http\Requests\User\UserRegisterRequest;
use App\Http\Resources\UserResource;
use App\Repositories\UserRepository;
use Couchbase\QueryException;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;
use Throwable;

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
      try {
        $user = $this->repository->store($request->all());

        return response()->json(new UserResource($user),  Response::HTTP_CREATED);
      } catch (\Exception $exception) {
        $message = $exception->getMessage();
        $code = Response::HTTP_BAD_REQUEST;

        return response()->json(['message' => $message, 'code' => $code], $code);
      }
    }
}
