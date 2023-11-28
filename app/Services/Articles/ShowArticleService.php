<?php

declare(strict_types=1);

namespace App\Services\Articles;

use App\Models\Article;
use App\Repositories\ArticleRepository;
use App\Repositories\ArticleRepositoryInterface;

class ShowArticleService
{
    private ArticleRepositoryInterface $articleRepository;

    public function __construct()
    {
        $this->articleRepository = new ArticleRepository();
    }

    public function execute(int $id): Article
    {
        return $this->articleRepository->getById($id);
    }
}