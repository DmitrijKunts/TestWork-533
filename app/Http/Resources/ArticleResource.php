<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class ArticleResource extends JsonResource
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
            'id' => $this->id,
            'title' => $this->title,
            'cover' => $this->cover,
            'body' => $this->body,
            'tags' => ArticleTagResource::collection($this->whenLoaded('tags')),
            'priority' => $this->whenPivotLoaded('article_article_tag', function () {
                return $this->pivot->priority;
            }),
        ];
    }
}
