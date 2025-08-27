<?php

namespace App\Application\Actions\Api;

use App\Application\Actions\BaseAction;
use App\Domain\Repositories\SentenceRepository;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Log\LoggerInterface;
use Valitron\Validator;

class ListSentencesAction extends BaseAction
{
    private SentenceRepository $sentencesRepo;

    public function __construct(
        LoggerInterface $logger,
        SentenceRepository $repository,
        Validator $validator
    ) {
        parent::__construct($logger, $repository, $validator);
        $this->sentencesRepo = $repository;
    }

    protected function action(): Response
    {
        $params = $this->request->getQueryParams();
        if (isset($params['sl']) && isset($params['tl'])) {
            $sentences = $this->sentencesRepo->getByLanguages($params['sl'], $params['tl'], $params['lu'] ?? null);
        } else {
            $sentences = $this->repository->getAll();
        }

        $this->logger->info("Sentences list was viewed.");

        return $this->respondWithData($sentences);
    }
}
