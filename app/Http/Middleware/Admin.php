<?php

namespace App\Http\Middleware;

use App\Models\User;
use Closure;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class Admin
{
    /**
     * @param Request $request
     * @param Closure $next
     * @return mixed
     * @throws \Throwable
     */
    public function handle(Request $request, Closure $next)
    {
      /** @var User $user */
      $user = auth()->user();

      throw_unless($user->role == 5, new AuthorizationException('Unauthorized'), Response::HTTP_UNAUTHORIZED);

      return $next($request);
    }
}
