<?php

declare(strict_types=1);

namespace App\Domain\Repositories;

interface RepositoryInterface
{
    public function getTableName(): string;

    public function getAll(): array;

    public function getById(int $id): array;

    public function create(array $data): void;

    public function update(int $id, array $data): int;

    public function delete(int $id): int;
}
