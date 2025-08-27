<?php

declare(strict_types=1);

namespace App\Infrastructure\Persistence\User;

use App\Infrastructure\Persistence\Database;
use PDO;

abstract class DatabaseRepository implements RepositoryInterface
{
    public function __construct(
        protected Database $database
    ) {
    }

    public function getAll(): array
    {
        $pdo = $this->database->getConnection();
        $stmt = $pdo->query("SELECT * FROM {$this->getTableName()}");

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    abstract public function getById(int $id): array;

    abstract public function create(array $data): int;

    abstract public function update(int $id, array $data): int;

    abstract public function delete(int $id): int;

    abstract public function getTableName(): string;
}
