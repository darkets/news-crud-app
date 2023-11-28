<?php

namespace App\Models;

use Carbon\Carbon;

class Article
{
    private string $title;
    private string $description;
    private string $picture;
    private Carbon $createdAt;
    private ?Carbon $updatedAt;
    private ?int $id;

    public function __construct(
        string         $title,
        string         $description,
        string         $picture,
        \Carbon\Carbon $createdAt,
        ?int           $id = null,
        ?string        $updatedAt = null
    )
    {
        $this->title = $title;
        $this->description = $description;
        $this->picture = $picture;
        $this->id = $id;
        $this->createdAt = new Carbon($createdAt);
        $this->updatedAt = $updatedAt ? new Carbon($updatedAt) : null;
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTitle(): string
    {
        return $this->title;
    }

    public function getDescription(): string
    {
        return $this->description;
    }

    public function getPicture(): string
    {
        return $this->picture;
    }

    public function getCreatedAt(): Carbon
    {
        return $this->createdAt;
    }

    public function getUpdatedAt(): ?Carbon
    {
        return $this->updatedAt;
    }

    public function update(string $title, string $description, string $imageUrl)
    {
        $this->title = $title;
        $this->description = $description;
        $this->picture = $imageUrl;
        $this->updatedAt = Carbon::now();
    }
}