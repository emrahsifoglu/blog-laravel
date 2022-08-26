<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class CommentResource extends JsonResource
{
    /** @var bool  */
    protected bool $withCommenter = false;

    /**
     * withCommenter
     *
     * @return $this
     */
    public function withCommenter(): self
    {
      $this->withCommenter = true;
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
        'id' => $this->id,
        'text' => $this->text,
        'createdAt' => $this->created_at,
        'updatedAt' => $this->updated_at
      ];

      if ($this->withCommenter) {
        $data['commenter'] = new UserResource($this->commenter);
      }

      return $data;
    }
}
