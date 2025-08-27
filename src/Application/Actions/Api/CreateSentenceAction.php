<?php

namespace App\Application\Actions\Api;

use App\Application\Actions\BaseAction;
use App\Domain\Repositories\LanguageRepository;
use App\Domain\Repositories\SentenceRepository;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Log\LoggerInterface;
use Valitron\Validator;

class CreateSentenceAction extends BaseAction
{
    public function __construct(
        LoggerInterface $logger,
        SentenceRepository $repository,
        Validator $validator,
        LanguageRepository $langRepository
    ) {
        parent::__construct($logger, $repository, $validator);

        $this->validator->rule(function ($field, $value, array $params, array $fields) use ($langRepository) {
            if ($value) {
                return !empty($langRepository->getById($value));
            }

            return true;
        }, ["source_language_id", "target_language_id", "learning_unit_id"]);

        $this->validator->mapFieldsRules([
            'source_language_id' => ['required', 'integer'],
            'target_language_id' => ['required', 'integer'],
            'learning_unit_id' => ['optional', 'integer'],
            'sentence' => ['required',  ['lengthMax', 700]],
            'translation' => ['required',  ['lengthMax', 700]],
            'grammar_type' => ['optional', 'integer'],
            'is_learning' => ['required', 'boolean'],
        ]);
    }


    protected function action(): Response
    {
        $body = $this->request->getParsedBody();
        $response = $this->validate($body);
        if ($response instanceof Response) {
            return $response;
        }

        $body['learning_updated'] = (new \DateTime())->format('Y-m-d H:i:s');

        $id = $this->repository->create($body);

        $this->logger->info("Sentence (id: {$id}) was created.");

        return $this->respondWithData([
            'message' => 'Sentence created.',
            'id' => $id,
        ], 201);
    }
}
