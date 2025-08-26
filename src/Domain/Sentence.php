<?php

declare(strict_types=1);

namespace App\Domain;

use JsonSerializable;

class Sentence implements JsonSerializable
{
    public function __construct(
        private ?int $id,
        private int $sourceLanguageId,
        private int $targetLanguageId,
        private ?int $learningUnitId,
        private string $sentence,
        private string $translation,
        private ?int $grammarType,
        private bool $isLearning,
        private string $learningUpdated
    ) {
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getSourceLanguageId(): int
    {
        return $this->sourceLanguageId;
    }

    public function getTargetLanguageId(): int
    {
        return $this->targetLanguageId;
    }

    public function getLearningUnitId(): ?int
    {
        return $this->learningUnitId;
    }

    public function getSentence(): string
    {
        return $this->sentence;
    }

    public function getTranslation(): string
    {
        return $this->translation;
    }

    public function getGrammarType(): ?int
    {
        return $this->grammarType;
    }

    public function isLearning(): bool
    {
        return $this->isLearning;
    }

    public function getLearningUpdated(): string
    {
        return $this->learningUpdated;
    }

    public function setId(?int $id): void
    {
        $this->id = $id;
    }

    public function setSourceLanguageId(int $sourceLanguageId): void
    {
        $this->sourceLanguageId = $sourceLanguageId;
    }

    public function setTargetLanguageId(int $targetLanguageId): void
    {
        $this->targetLanguageId = $targetLanguageId;
    }

    public function setLearningUnitId(?int $learningUnitId): void
    {
        $this->learningUnitId = $learningUnitId;
    }

    public function setSentence(string $sentence): void
    {
        $this->sentence = $sentence;
    }

    public function setTranslation(string $translation): void
    {
        $this->translation = $translation;
    }

    public function setGrammarType(?int $grammarType): void
    {
        $this->grammarType = $grammarType;
    }

    public function setIsLearning(bool $isLearning): void
    {
        $this->isLearning = $isLearning;
    }

    public function setLearningUpdated(string $learningUpdated): void
    {
        $this->learningUpdated = $learningUpdated;
    }

    #[\ReturnTypeWillChange]
    public function jsonSerialize(): array
    {
        return [
            'id' => $this->getId(),
            'source_language_id' => $this->getSourceLanguageId(),
            'target_language_id' => $this->getTargetLanguageId(),
            'learning_unit_id' => $this->getLearningUnitId(),
            'sentence' => $this->getSentence(),
            'translation' => $this->getTranslation(),
            'grammar_type' => $this->getGrammarType(),
            'is_learning' => $this->isLearning(),
            'learning_updated' => $this->getLearningUpdated(),
        ];
    }
}
