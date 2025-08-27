<?php

declare(strict_types=1);

namespace App\Domain\Models;

use JsonSerializable;

class Language implements JsonSerializable
{
    public function __construct(
        private ?int $id,
        private string $language
    ) {
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getLanguage(): string
    {
        return $this->language;
    }

    public function setId(?int $id): void
    {
        $this->id = $id;
    }

    public function setLanguage(string $language): void
    {
        $this->language = $language;
    }

    #[\ReturnTypeWillChange]
    public function jsonSerialize(): array
    {
        return [
            'id' => $this->getId(),
            'language' => $this->getLanguage(),
        ];
    }
}
