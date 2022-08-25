<?php

declare(strict_types=1);

namespace App\Http\Controllers\Api\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use App\Http\Resources\UserResource;
use App\Models\User;
use App\Repositories\UserRepository;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;

class AuthController extends Controller
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

    public function authenticate(LoginRequest $request): JsonResponse
    {
      try {
        $credentials = $request->only(['email', 'password']);

        if (!auth()->attempt($credentials)) {
          return response()->json(['message' => 'unauthorized', 'code' => 401], Response::HTTP_UNAUTHORIZED);
        }

        /** @var User $user */
        $user = auth()->user();
        $token = $user->createToken('API TOKEN')->plainTextToken;

        return response()->json((new UserResource($user))->withToken($token), Response::HTTP_CREATED);
      } catch (\Exception $exception) {
        $message = $exception->getMessage();
        $code = Response::HTTP_INTERNAL_SERVER_ERROR;

        return response()->json(['message' => $message, 'code' => $code], $code);
      }
    }
}