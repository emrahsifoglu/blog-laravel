<?php

declare(strict_types=1);

namespace App\Http\Controllers\Api\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use App\Http\Resources\UserResource;
use App\Models\User;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;

class AuthController extends Controller
{
    /**
     * @throws \Throwable
     */
    public function authenticate(LoginRequest $request): JsonResponse
    {
      $credentials = $request->only(['email', 'password']);

      throw_if(!auth()->attempt($credentials), new AuthorizationException('Unauthorized'));

      /** @var User $user */
      $user = auth()->user();
      $token = $user->createToken('API TOKEN')->plainTextToken;

      return response()->json((new UserResource($user))->withToken($token), Response::HTTP_CREATED);
    }
}
