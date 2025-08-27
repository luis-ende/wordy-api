<?php

declare(strict_types=1);

namespace App\Infrastructure\Persistence\User;

interface RepositoryInterface
{
    public function getTableName(): string;

    public function getAll(): array;

    public function getById(int $id): array;

    public function create(array $data): int;

    public function update(int $id, array $data): int;

    public function delete(int $id): int;
}
