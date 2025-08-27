<?php

namespace App\Domain\Repositories;

use App\Infrastructure\Persistence\User\DatabaseRepository;

class LearningUnitsRepository extends DatabaseRepository
{
    public function getTableName(): string
    {
        return 'learning_units';
    }

    public function getById(int $id): array
    {
        return [];
    }

    public function create(array $data): void
    {
        // TODO: Implement create() method.
    }

    public function update(int $id, array $data): int
    {
        return 0;
    }

    public function delete(int $id): int
    {
        return 0;
    }
}
