<?php

namespace App\Repositories;

use App\Http\Resources\ArticleResource;
use App\Models\Article;
use App\Repositories\Interfaces\ArticleRepositoryInterface;

class ArticleRepository implements ArticleRepositoryInterface
{
    public function all()
    {
        return ArticleResource::collection(Article::with('tags')->get());
    }

    public function getById($id)
    {
        return new ArticleResource(Article::with('tags')->findOrFail($id));
    }

    public function search($field, $value, $sort = null)
    {
        $articles = Article::with(['tags' => function ($q) use ($field, $value, $sort) {
            //Сортировкаи и фильтры внутри релашион
            if ($sort == 'name') {
                $q->reorder('article_tags.name');
            }
            if ($sort == 'priority') {
                $q->reorder('article_article_tag.priority');
            }

            if ($field == 'name') {
                $q->where('article_tags.name', 'like', "%$value%");
            }
            if ($field == 'priority') {
                $q->where('article_article_tag.priority', $value);
            }
        }]);

        //Наличие значения внутри релашион
        if (in_array($field, ['name', 'priority'])) {
            $articles = $articles->whereHas('tags', function ($q) use ($field, $value) {
                if ($field == 'name') {
                    $q->where('article_tags.name', 'like', "%$value%");
                }
                if ($field == 'priority') {
                    $q->where('article_article_tag.priority', $value);
                }
            });
        }

        //Сортировка и фильтры в основной таблице
        if (in_array($field, ['title', 'cover', 'body'])) {
            $articles = $articles->where($field, 'like', "%$value%");
        }
        if (in_array($sort, ['title', 'cover', 'body'])) {
            $articles = $articles->orderBy($sort);
        }

        return ArticleResource::collection($articles->get());
    }
}
