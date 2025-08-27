<?php

declare(strict_types=1);

namespace App\Infrastructure\Persistence;

use PDO;

class Database
{
    public function __construct(
        private string $dbPath,
    ) {
    }

    public function getConnection(): PDO
    {
        $pdo = new PDO("sqlite:" . $this->dbPath);
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        return $pdo;
    }
}
