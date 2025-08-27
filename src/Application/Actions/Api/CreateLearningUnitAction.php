<?php

namespace App\Application\Actions\Api;

use App\Application\Actions\BaseAction;
use App\Domain\Repositories\LearningUnitsRepository;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Log\LoggerInterface;
use Valitron\Validator;

class CreateLearningUnitAction extends BaseAction
{
    public function __construct(
        LoggerInterface $logger,
        LearningUnitsRepository $repository,
        Validator $validator
    ) {
        parent::__construct($logger, $repository, $validator);

        $this->validator->mapFieldsRules([
            'name' => ['required',  ['lengthMax', 120]],
        ]);
    }


    protected function action(): Response
    {
        $body = $this->request->getParsedBody();
        $response = $this->validate($body);
        if ($response instanceof Response) {
            return $response;
        }

        $id = $this->repository->create($body);

        $this->logger->info("Learning Unit (id: {$id}) was created.");

        return $this->respondWithData([
            'message' => 'Learning unit created.',
            'id' => $id,
        ], 201);
    }
}
