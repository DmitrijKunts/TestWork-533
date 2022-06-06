<?php

namespace App\Repositories;

use App\Models\ArticleTag;
use App\Repositories\Interfaces\ArticleTagRepositoryInterface;

class ArticleTagRepository implements ArticleTagRepositoryInterface
{
    public function all()
    {
        return ArticleTag::with('articles')->get();
    }

    public function getById($id)
    {
        return ArticleTag::with('articles')->findOrFail($id);
    }

    public function search($field, $value, $sort = null)
    {
        $tags = ArticleTag::with(['articles' => function ($q) use ($field, $value, $sort) {
            //Сортировкаи и фильтры внутри релашион
            if (in_array($sort, ['title', 'cover', 'body'])) {
                $q->reorder("articles.$sort");
            }
            if ($sort == 'priority') {
                $q->reorder('article_article_tag.priority');
            }

            if (in_array($field, ['title', 'cover', 'body'])) {
                $q->where("articles.$field", 'like', "%$value%");
            }
            if ($field == 'priority') {
                $q->where('article_article_tag.priority', $value);
            }
        }]);

        //Наличие значения внутри релашион
        if (in_array($field, ['title', 'cover', 'body', 'priority'])) {
            $tags = $tags->whereHas('articles', function ($q) use ($field, $value) {
                if (in_array($field, ['title', 'cover', 'body'])) {
                    $q->where("articles.$field", 'like', "%$value%");
                }
                if ($field == 'priority') {
                    $q->where('article_article_tag.priority', $value);
                }
            });
        }

        //Сортировка и фильтры в основной таблице
        if (in_array($field, ['name'])) {
            $tags = $tags->where($field, 'like', "%$value%");
        }
        if (in_array($sort, ['name'])) {
            $tags = $tags->orderBy($sort);
        }

        return $tags->get();
    }
}
