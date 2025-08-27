<?php

declare(strict_types=1);

namespace App\Domain\Repositories;

use App\Infrastructure\Persistence\User\DatabaseRepository;
use PDO;

class SentenceRepository extends DatabaseRepository
{
    public function getTableName(): string
    {
        return 'sentences';
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
        $stmt = $pdo->prepare("
            INSERT INTO {$this->getTableName()} 
            (source_language_id, target_language_id, learning_unit_id, 
             sentence, translation, grammar_type, is_learning, learning_updated) 
            VALUES (?, ?, ?, ?, ?, ?, ?, ?)
        ");
        $stmt->execute([
            $data['source_language_id'],
            $data['target_language_id'],
            $data['learning_unit_id'],
            $data['sentence'],
            $data['translation'],
            $data['grammar_type'],
            $data['is_learning'] ? 1 : 0,
            $data['learning_updated']
        ]);

        return (int) $pdo->lastInsertId();
    }

    public function update(int $id, array $data): int
    {
        $pdo = $this->database->getConnection();
        $stmt = $pdo->prepare("
            UPDATE {$this->getTableName()} 
            SET source_language_id = ?, target_language_id = ?, learning_unit_id = ?, 
                sentence = ?, translation = ?, grammar_type = ?, is_learning = ?, learning_updated = ?
            WHERE id = ?
        ");
        $stmt->execute([
            $data['source_language_id'],
            $data['target_language_id'],
            $data['learning_unit_id'],
            $data['sentence'],
            $data['translation'],
            $data['grammar_type'],
            $data['is_learning'] ? 1 : 0,
            $data['learning_updated'],
            $id
        ]);

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
     * Get sentences by learning unit ID
     */
    public function getByLearningUnitId(int $learningUnitId): array
    {
        $pdo = $this->database->getConnection();
        $stmt = $pdo->prepare("SELECT * FROM {$this->getTableName()} WHERE learning_unit_id = ?");
        $stmt->execute([$learningUnitId]);

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    /**
     * Get sentences by source and target language IDs
     */
    public function getByLanguages(int $sourceLanguageId, int $targetLanguageId): array
    {
        $pdo = $this->database->getConnection();
        $stmt = $pdo->prepare("
            SELECT * FROM {$this->getTableName()} 
            WHERE source_language_id = ? AND target_language_id = ?
        ");
        $stmt->execute([$sourceLanguageId, $targetLanguageId]);

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    /**
     * Get learning sentences (is_learning = true)
     */
    public function getLearningSentences(): array
    {
        $pdo = $this->database->getConnection();
        $stmt = $pdo->query("SELECT * FROM {$this->getTableName()} WHERE is_learning = 1");

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}
