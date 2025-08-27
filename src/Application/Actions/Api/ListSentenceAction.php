<?php

namespace App\Application\Actions\Api;

use App\Application\Actions\BaseAction;
use App\Domain\Repositories\SentenceRepository;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Log\LoggerInterface;
use Valitron\Validator;

class ListSentenceAction extends BaseAction
{
    public function __construct(
        LoggerInterface $logger,
        SentenceRepository $repository,
        Validator $validator
    ) {
        parent::__construct($logger, $repository, $validator);
    }

    protected function action(): Response
    {
        $sentences = $this->repository->getAll();

        $this->logger->info("Sentences list was viewed.");

        return $this->respondWithData($sentences);
    }
}
