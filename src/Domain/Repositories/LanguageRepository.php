<?php

declare(strict_types=1);

namespace App\Domain\Repositories;

use App\Infrastructure\Persistence\User\DatabaseRepository;
use PDO;

class LanguageRepository extends DatabaseRepository
{
    public function getTableName(): string
    {
        return 'languages';
    }

    public function getById(int $id): array
    {
        $pdo = $this->database->getConnection();
        $stmt = $pdo->prepare("SELECT * FROM {$this->getTableName()} WHERE id = ?");
        $stmt->execute([$id]);

        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        return $result ?: [];
    }

    public function create(array $data): int
    {
        $pdo = $this->database->getConnection();
        $stmt = $pdo->prepare("INSERT INTO {$this->getTableName()} (language) VALUES (?)");
        $stmt->execute([$data['language']]);

        return (int) $pdo->lastInsertId();
    }

    public function update(int $id, array $data): int
    {
        $pdo = $this->database->getConnection();
        $stmt = $pdo->prepare("UPDATE {$this->getTableName()} SET language = ? WHERE id = ?");
        $stmt->execute([$data['language'], $id]);

        return $stmt->rowCount();
    }

    public function delete(int $id): int
    {
        $pdo = $this->database->getConnection();
        $stmt = $pdo->prepare("DELETE FROM {$this->getTableName()} WHERE id = ?");
        $stmt->execute([$id]);

        return $stmt->rowCount();
    }
}
