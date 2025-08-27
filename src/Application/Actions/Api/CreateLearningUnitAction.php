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
        private Validator $validator
    ) {
        parent::__construct($logger, $repository);
        $this->validator->mapFieldsRules([
            'name' => ['required',  ['lengthMax', 120]],
        ]);
    }


    protected function action(): Response
    {
        $body = $this->request->getParsedBody();
        $this->validator = $this->validator->withData($body);
        if (! $this->validator->validate()) {
            $this->response
                ->getBody()
                ->write(json_encode([$this->validator->errors()]));

            return $this->response->withStatus(422);
        }


        $id = $this->repository->create($body);

        $this->logger->info("Learning Unit (id: {$id}) was created.");

        return $this->respondWithData([
            'message' => 'Learning unit created.',
            'id' => $id,
        ], 201);
    }
}
