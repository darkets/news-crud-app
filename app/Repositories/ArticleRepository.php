<?php

declare(strict_types=1);

namespace App\Repositories;

use App\Models\Article;
use App\Collections\ArticleCollection;
use Carbon\Carbon;
use Doctrine\DBAL\Connection;
use Doctrine\DBAL\DriverManager;

class ArticleRepository implements ArticleRepositoryInterface
{
    private Connection $db;

    public function __construct()
    {
        $connectionParams = [
            'dbname' => $_ENV['DB_NAME'],
            'user' => $_ENV['DB_USER'],
            'password' => $_ENV['DB_PASSWORD'],
            'host' => $_ENV['DB_HOST'],
            'driver' => $_ENV['DB_DRIVER'],
        ];
        $this->db = DriverManager::getConnection($connectionParams);
    }

    public function getAll(): ArticleCollection
    {
        $response = $this->db->createQueryBuilder()
            ->select('*')
            ->from('articles')
            ->orderBy('id', 'desc')
            ->fetchAllAssociative();

        $articleCollection = new ArticleCollection();

        foreach ($response as $article) {
            $articleCollection->add($this->buildModel($article));
        }

        return $articleCollection;
    }

    public function getById(int $id): ?Article
    {
        $response = $this->db->createQueryBuilder()
            ->select('*')
            ->from('articles')
            ->where('id = :id')
            ->setParameter('id', $id)
            ->fetchAssociative();

        if (empty($response)) {
            return null;
        }

        return $this->buildModel($response);
    }

    public function update(Article $article): void
    {
        $this->db->createQueryBuilder()
            ->update('articles')
            ->set('title', ':title')
            ->set('description', ':description')
            ->set('picture', ':picture')
            ->set('updated_at', ':updated_at')
            ->where('id = :id')
            ->setParameters([
                'id' => $article->getId(),
                'title' => $article->getTitle(),
                'description' => $article->getDescription(),
                'picture' => $article->getPicture(),
                'updated_at' => $article->getUpdatedAt(),
            ])->executeQuery();
    }

    public function store(Article $article): void
    {
        $this->db->createQueryBuilder()
            ->insert('articles')
            ->values([
                    'title' => ':title',
                    'description' => ':description',
                    'picture' => ':picture',
                    'created_at' => ':created_at'
                ]
            )->setParameters([
                'title' => $article->getTitle(),
                'description' => $article->getDescription(),
                'picture' => $article->getPicture(),
                'created_at' => $article->getCreatedAt()
            ])->executeQuery();
    }

    public function delete(Article $article): void
    {
        $this->db->createQueryBuilder()
            ->delete('articles')
            ->where('id = :id')
            ->setParameter('id', $article->getId())
            ->executeQuery();
    }

    private function buildModel(array $article): Article
    {
        return new Article(
            $article['title'],
            $article['description'],
            $article['picture'],
            Carbon::parse($article['created_at']),
            (int) $article['id'],
            $article['updated_at']
        );
    }
}