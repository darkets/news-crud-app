<?php

declare(strict_types=1);

namespace App\Services\Articles;

use App\Repositories\ArticleRepository;
use App\Repositories\ArticleRepositoryInterface;

class StoreArticleService
{
    private ArticleRepositoryInterface $articleRepository;

    public function __construct()
    {
        $this->articleRepository = new ArticleRepository();
    }

    public function execute($article): void
    {
        $this->articleRepository->store($article);
    }
}