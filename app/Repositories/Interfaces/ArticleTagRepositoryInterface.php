<?php

namespace App\Repositories\Interfaces;

interface ArticleTagRepositoryInterface
{
    public function all();
    public function getById($id);
    public function search($field, $value, $sort = null);
}
