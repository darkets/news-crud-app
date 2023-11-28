<?php

declare(strict_types=1);

namespace App\Controllers;

use App\Models\Article;
use App\Collections\ArticleCollection;
use App\Response;
use App\RedirectResponse;
use App\Services\Articles\DeleteArticleService;
use App\Services\Articles\IndexArticleService;
use App\Services\Articles\ShowArticleService;
use App\Services\Articles\StoreArticleService;
use App\Services\Articles\UpdateArticleService;
use App\ViewResponse;
use Carbon\Carbon;

class ArticleController
{
    public function index(): Response
    {
        $service = new IndexArticleService();
        $articles = $service->execute();

        return new ViewResponse('articles/index', [
            'articles' => $articles
        ]);
    }

    public function show(int $id): Response
    {
        $service = new ShowArticleService();
        $article = $service->execute($id);

        return new ViewResponse('articles/show', [
            'article' => $article
        ]);
    }

    public function create(): Response
    {
        return new ViewResponse('articles/create');
    }

    public function store(): RedirectResponse
    {
        $article = new Article(
            $_POST['title'],
            $_POST['description'],
            'https://t3.ftcdn.net/jpg/03/45/05/92/360_F_345059232_CPieT8RIWOUk4JqBkkWkIETYAkmz2b75.jpg',
            Carbon::now()
        );

        $service = new StoreArticleService();

        $service->execute($article);

        return new RedirectResponse('/articles');
    }

    public function edit(int $id): ViewResponse
    {
        $service = new ShowArticleService();
        $article = $service->execute($id);

        return new ViewResponse('articles/edit', [
            'article' => $article
        ]);
    }

    public function update(int $id): RedirectResponse
    {
        $service = new UpdateArticleService();

        $service->execute(
            $id,
            $_POST['title'],
            $_POST['description'],
            $_POST['image']
        );

        return new RedirectResponse('/articles');
    }

    public function delete(int $id): RedirectResponse
    {
        $service = new DeleteArticleService();
        $service->execute($id);

        return new RedirectResponse('/articles');
    }
}