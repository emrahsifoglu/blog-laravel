<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class UserResource extends JsonResource
{
    /** @var string */
    protected string $token;

    /**
     * withToken
     *
     * @param string $token
     * @return $this
     */
    public function withToken(string $token): self
    {
      $this->token = $token;
      return $this;
    }

    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
      $data = [
        'nickname' => $this->nickname,
        'name' => $this->name,
        'surname' => $this->surname,
        'email' => $this->email,
        'phone' => $this->phone,
        'createdAt' => $this->created_at,
        'updatedAt' => $this->updated_at
      ];

      if (isset($this->token)) {
        $data['token'] = [
          'accessToken' => $this->token,
          'tokenType' => 'bearer'
        ];
      }

      return $data;
    }
}
