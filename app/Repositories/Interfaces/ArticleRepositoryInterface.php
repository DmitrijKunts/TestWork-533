<?php

namespace App\Repositories\Interfaces;

interface ArticleRepositoryInterface
{
    public function all();
    public function getById($id);
    public function search($field, $value, $sort = null);
}
