<?php

declare(strict_types=1);

namespace App\Services\Articles;

use App\Repositories\ArticleRepositoryInterface;
use App\Repositories\ArticleRepository;

class UpdateArticleService
{
    private ArticleRepositoryInterface $articleRepository;
    public function __construct()
    {
        $this->articleRepository = new ArticleRepository();
    }

    public function execute(int $id, string $title, string $description, string $imageUrl): void
    {
        $article = $this->articleRepository->getByID($id);

        if ($article == null) {
            return;
        }

        $article->update(
            $title,
            $description,
            $imageUrl
        );

        $this->articleRepository->update($article);
    }
}