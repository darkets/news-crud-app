<?php

declare(strict_types=1);

namespace App\Services\Articles;

use App\Repositories\ArticleRepositoryInterface;
use App\Repositories\ArticleRepository;

class DeleteArticleService
{
    private ArticleRepositoryInterface $articleRepository;

    public function __construct()
    {
        $this->articleRepository = new ArticleRepository();
    }

    public function execute(int $id): void
    {
        $response = $this->articleRepository->getById($id);

        if ($response == null) {
            return;
        }

        $this->articleRepository->delete($response);
    }
}