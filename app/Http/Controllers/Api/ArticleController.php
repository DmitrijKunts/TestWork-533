<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\SearchRequest;
use App\Http\Resources\ArticleResource;
use App\Repositories\Interfaces\ArticleRepositoryInterface;
use Illuminate\Http\Request;

class ArticleController extends Controller
{
    public function __construct(private ArticleRepositoryInterface $articleRepository)
    {
    }

    private function respone($articles)
    {
        return response()->json([
            "success" => true,
            "articles" => $articles
        ]);
    }

    public function index()
    {
        return $this->respone(ArticleResource::collection($this->articleRepository->all()));
    }

    public function getById($id)
    {
        return $this->respone(new ArticleResource($this->articleRepository->getById($id)));
    }

    public function search(SearchRequest $request)
    {
        return $this->respone(
            ArticleResource::collection(
                $this->articleRepository
                    ->search($request->field, $request->value, $request->sort ?? null)
            )
        );
    }
}
