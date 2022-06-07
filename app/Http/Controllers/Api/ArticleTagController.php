<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\SearchRequest;
use App\Repositories\Interfaces\ArticleTagRepositoryInterface;

class ArticleTagController extends Controller
{
    public function __construct(private ArticleTagRepositoryInterface $articleTagRepository)
    {
    }

    private function respone($tags)
    {
        return response()->json([
            "success" => true,
            "tags" => $tags
        ]);
    }

    public function index()
    {
        return $this->respone($this->articleTagRepository->all());
    }

    public function getById($id)
    {
        return $this->respone($this->articleTagRepository->getById($id));
    }

    public function search(SearchRequest $request)
    {
        return $this->respone(
            $this->articleTagRepository
                ->search($request->field, $request->value, $request->sort ?? null)
        );
    }
}
