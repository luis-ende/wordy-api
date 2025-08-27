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

    /**
     * Get sentences by source and target language IDs
     */
    public function getByLanguages(int $sourceLanguageId, int $targetLanguageId, ?int $learningUnit = null): array
    {
        $pdo = $this->database->getConnection();
        $query = "
            SELECT * FROM {$this->getTableName()} 
            WHERE source_language_id = :sl AND target_language_id = :tl
        ";
        if ($learningUnit > 0) {
            $query .= " AND learning_unit_id = :lu";
        }
        $stmt = $pdo->prepare($query);

        $stmt->bindParam(":sl", $sourceLanguageId, PDO::PARAM_INT);
        $stmt->bindParam(":tl", $targetLanguageId, PDO::PARAM_INT);
        if ($learningUnit > 0) {
            $stmt->bindParam(":lu", $learningUnit, PDO::PARAM_INT);
        }

        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}
