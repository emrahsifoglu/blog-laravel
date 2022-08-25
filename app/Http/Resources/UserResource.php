<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class UserResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
      return [
        'nickname' => $this->nickname,
        'name' => $this->name,
        'surname' => $this->surname,
        'email' => $this->email,
        'phone' => $this->phone,
        'createdAt' => $this->created_at,
        'updatedAt' => $this->updated_at
      ];
    }
}
