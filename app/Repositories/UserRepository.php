<?php

namespace App\Repositories;

use App\Models\User;
use Illuminate\Support\Str;

class UserRepository
{
    /**
     * store
     *
     * @param array $parameters
     * @return User
     */
    public function store(array $parameters): User
    {
      $parameters['id'] = Str::uuid();
      $parameters['nickname'] =
        Str::substr($parameters['name'], 0, 3) .
        Str::substr($parameters['surname'], 0, 3);

      $user = new User($parameters);
      $user->save();

      return $user->fresh();
    }

    /**
     * @param string $email
     * @return User
     */
    public function findByEmail(string $email): User
    {
      /** @var User $user */
      $user = User::query()
        ->where('email', '=', $email)
        ->firstOrFail();

      return $user;
    }
}
