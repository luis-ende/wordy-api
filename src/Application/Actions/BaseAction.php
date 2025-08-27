<?php

namespace App\Application\Actions;

use App\Infrastructure\Persistence\User\RepositoryInterface;
use Psr\Log\LoggerInterface;
use Psr\Http\Message\ResponseInterface as Response;
use Valitron\Validator;

abstract class BaseAction extends Action
{
    public function __construct(
        LoggerInterface $logger,
        protected RepositoryInterface $repository,
        protected Validator $validator
    ) {
        parent::__construct($logger);
    }

    protected function validate(array | null | object $body): Response | null
    {
        $this->validator = $this->validator->withData($body);
        if (! $this->validator->validate()) {
            $this->response
                ->getBody()
                ->write(json_encode([$this->validator->errors()]));

            return $this->response->withStatus(422);
        }

        return null;
    }
}
