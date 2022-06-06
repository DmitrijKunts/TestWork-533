<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class ArticleTagResource extends JsonResource
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
            'name' => $this->name,
            'articles' => ArticleResource::collection($this->whenLoaded('articles')),
            'priority' => $this->whenPivotLoaded('article_article_tag', function () {
                return $this->pivot->priority;
            }),
        ];
    }
}
