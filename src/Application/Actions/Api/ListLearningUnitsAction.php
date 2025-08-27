<?php

namespace App\Application\Actions\Api;

use App\Application\Actions\BaseAction;
use App\Domain\Repositories\LearningUnitsRepository;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Log\LoggerInterface;
use Valitron\Validator;

class ListLearningUnitsAction extends BaseAction
{
    public function __construct(
        LoggerInterface $logger,
        LearningUnitsRepository $repository,
        Validator $validator
    ) {
        parent::__construct($logger, $repository, $validator);
    }

    protected function action(): Response
    {
        $units = $this->repository->getAll();

        $this->logger->info("Learning Units list was viewed.");

        return $this->respondWithData($units);
    }
}
