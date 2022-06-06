<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\SearchRequest;
use App\Http\Resources\ArticleResource;
use App\Http\Resources\ArticleTagResource;
use App\Models\Article;
use App\Repositories\Interfaces\ArticleTagRepositoryInterface;
use Illuminate\Http\Request;

class ArticleTagController extends Controller
{
    public function __construct(private ArticleTagRepositoryInterface $articleTagRepository)
    {
    }

    private function respone($tags){
        return response()->json([
            "success" => true,
            "tags" => $tags
        ]);
    }

    public function index()
    {
        return $this->respone(ArticleTagResource::collection($this->articleTagRepository->all()));
    }

    public function getById($id)
    {
        return $this->respone(new ArticleTagResource($this->articleTagRepository->getById($id)));
    }

    public function search(SearchRequest $request)
    {
        return $this->respone(
            ArticleTagResource::collection(
                $this->articleTagRepository
                    ->search($request->field, $request->value, $request->sort ?? null)
            )
        );
    }
}
