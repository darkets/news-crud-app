<?php

declare(strict_types=1);

namespace App\Controllers;

use App\Models\Article;
use App\Collections\ArticleCollection;
use App\Response;
use App\RedirectResponse;
use App\ViewResponse;
use Carbon\Carbon;

class ArticleController extends BaseController
{

    public function index(): Response
    {
        $articles = $this->database->createQueryBuilder()
            ->select('*')
            ->from('articles')
            ->fetchAllAssociative();

        $articlesCollection = new ArticleCollection();

        foreach ($articles as $article) {
            $articlesCollection->add(new Article(
                $article['title'],
                $article['description'],
                $article['picture'],
                $article['created_at'],
                (int) $article['id'],
                $article['updated_at']
            ));
        }

        return new ViewResponse('articles/index', ['articles' => $articlesCollection]);
    }


    public function show($id): Response
    {
        $data = $this->database->createQueryBuilder()
            ->select('*')
            ->from('articles')
            ->where('id = :id')
            ->setParameter('id', $id)
            ->fetchAssociative();

        $article = new Article(
            $data['title'],
            $data['description'],
            $data['picture'],
            $data['created_at'],
            (int) $data['id'],
            $data['updated_at']
        );

        return new ViewResponse('articles/show', ['article' => $article]);
    }

    public function create(): Response
    {
        return new ViewResponse('articles/create');
    }

    public function store(): RedirectResponse
    {
        $this->database->createQueryBuilder()
            ->insert('articles')
            ->values([
                    'title' => ':title',
                    'description' => ':description',
                    'picture' => ':picture',
                    'created_at' => ':created_at'
                ]
            )->setParameters([
                'title' => $_POST['title'],
                'description' => $_POST['description'],
                'picture' => '123',
                'created_at' => Carbon::now()
            ])->executeQuery();

        return new RedirectResponse('/articles');
    }

    public function edit(int $id): ViewResponse
    {
        $data = $this->database->createQueryBuilder()
            ->select('*')
            ->from('articles')
            ->where('id = :id')
            ->setParameter('id', $id)
            ->fetchAssociative();
        $article = new Article(
            $data['title'],
            $data['description'],
            $data['picture'],
            $data['created_at'],
            (int) $data['id'],
            $data['updated_at']
        );

        return new ViewResponse('articles/edit', ['article' => $article]);
    }

    public function update(int $id): RedirectResponse
    {
        $updateTime = Carbon::now();
        $this->database->createQueryBuilder()
            ->update('articles')
            ->set('title', ':title')
            ->set('description', ':description')
            ->set('picture', ':picture')
            ->set('updated_at', ':updated_at')
            ->where('id = :id')
            ->setParameters([
                'id' => $id,
                'title' => $_POST['title'],
                'description' => $_POST['description'],
                'picture' => $_POST['image'],
                'updated_at' => $updateTime->toDateTimeString(),
            ])->executeQuery();

        return new RedirectResponse('/articles');
    }

    public function delete(int $id): RedirectResponse
    {
        $this->database->createQueryBuilder()
            ->delete('articles')
            ->where('id = :id')
            ->setParameter('id', $id)
            ->executeQuery();

        return new RedirectResponse('/articles');
    }
}