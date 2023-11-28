<?php

namespace App\Repositories;

use App\Models\Article;
use App\Collections\ArticleCollection;

interface ArticleRepositoryInterface
{
    public function getAll(): ArticleCollection;

    public function getById(int $id): ?Article;

    public function update(Article $article): void;

    public function store(Article $article): void;

    public function delete(Article $article): void;
}