<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class PostResource extends JsonResource
{
    /** @var bool  */
    protected bool $withAuthor = false;

    /** @var bool  */
    protected bool $withComments = false;

    /**
     * withAuthor
     *
     * @return $this
     */
    public function withAuthor(): self
    {
      $this->withAuthor = true;
      return $this;
    }

    /**
     * withComments
     *
     * @return $this
     */
    public function withComments(): self
    {
      $this->withComments = true;
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
        'title' => $this->title,
        'description' => $this->description,
        'createdAt' => $this->created_at,
        'updatedAt' => $this->updated_at
      ];

      if ($this->withAuthor) {
        $data['author'] = new UserResource($this->author);
      }

      if ($this->withComments) {
        $data['comments'] = CommentResource::collection($this->comments);
      }

      return $data;
    }
}
