<?php

declare(strict_types=1);

namespace App\Controllers;

use Doctrine\DBAL\DriverManager;
use Doctrine\DBAL\Connection;

class BaseController
{
    protected Connection $database;

    public function __construct()
    {
        $connectionParams = [
            'dbname' => $_ENV['DB_NAME'],
            'user' => $_ENV['DB_USER'],
            'password' => $_ENV['DB_PASSWORD'],
            'host' => $_ENV['DB_HOST'],
            'driver' => $_ENV['DB_DRIVER'],
        ];
        $this->database = DriverManager::getConnection($connectionParams);
    }
}