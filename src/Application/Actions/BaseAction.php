<?php

namespace App\Application\Actions;

use App\Domain\Repositories\RepositoryInterface;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Log\LoggerInterface;

abstract class BaseAction extends Action
{
    public function __construct(
        LoggerInterface $logger,
        protected RepositoryInterface $repository
    ) {
        parent::__construct($logger);
    }
}
