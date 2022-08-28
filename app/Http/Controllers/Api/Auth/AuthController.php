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
     * @OA\Post(
     *     tags={"Users"},
     *     path="/api/login",
     *     operationId="authLogin",
     *     tags={"Login"},
     *     summary="User Login",
     *     description="Login User Here",
     *     @OA\RequestBody(
     *        description="login a user",
     *        required=true,
     *        @OA\MediaType(
     *            mediaType="application/json",
     *            @OA\Schema(
     *              type="object",
     *              required={"email", "password"},
     *              example={
     *                 "email": "name.surname@example.com",
     *                 "password": "password"
     *              },
     *              @OA\Property(property="email", type="email"),
     *              @OA\Property(property="password", type="password")
     *           ),
     *        ),
     *     ),
     *     @OA\Response(response="200", description="Authorized", @OA\JsonContent()),
     *     @OA\Response(response="401", description="Unauthorized", @OA\JsonContent()),
     *     @OA\Response(response="422", description="Unprocessable Entity", @OA\JsonContent()),
     * )
     * @throws \Throwable
     */
    public function authenticate(LoginRequest $request): JsonResponse
    {
      $credentials = $request->only(['email', 'password']);

      throw_if(!auth()->attempt($credentials), new AuthorizationException('Unauthorized'));

      /** @var User $user */
      $user = auth()->user();
      $token = $user->createToken('API TOKEN')->plainTextToken;

      return response()->json((new UserResource($user))->withToken($token), Response::HTTP_OK);
    }
}
