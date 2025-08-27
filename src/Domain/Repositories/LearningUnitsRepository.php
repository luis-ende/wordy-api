<?php

declare(strict_types=1);

namespace App\Domain\Repositories;

use App\Infrastructure\Persistence\User\DatabaseRepository;
use PDO;

class LearningUnitsRepository extends DatabaseRepository
{
    public function getTableName(): string
    {
        return 'learning_units';
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
        $stmt = $pdo->prepare("INSERT INTO {$this->getTableName()} (name) VALUES (?)");
        $stmt->execute([$data['name']]);

        return (int) $pdo->lastInsertId();
    }

    public function update(int $id, array $data): int
    {
        $pdo = $this->database->getConnection();
        $stmt = $pdo->prepare("UPDATE {$this->getTableName()} SET name = ? WHERE id = ?");
        $stmt->execute([$data['name'], $id]);

        return $stmt->rowCount();
    }

    public function delete(int $id): int
    {
        $pdo = $this->database->getConnection();
        $stmt = $pdo->prepare("DELETE FROM {$this->getTableName()} WHERE id = ?");
        $stmt->execute([$id]);

        return $stmt->rowCount();
    }

    /**
     * Get learning units by name (case-insensitive search)
     */
    public function getByName(string $name): array
    {
        $pdo = $this->database->getConnection();
        $stmt = $pdo->prepare("SELECT * FROM {$this->getTableName()} WHERE LOWER(name) LIKE LOWER(?)");
        $stmt->execute(['%' . $name . '%']);

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    /**
     * Get learning units with sentence count
     */
    public function getWithSentenceCount(): array
    {
        $pdo = $this->database->getConnection();
        $stmt = $pdo->query("
            SELECT lu.*, COUNT(e.id) as sentence_count 
            FROM {$this->getTableName()} lu 
            LEFT JOIN expressions e ON lu.id = e.learning_unit_id 
            GROUP BY lu.id, lu.name
        ");

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}
