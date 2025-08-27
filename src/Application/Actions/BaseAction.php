<?php

namespace App\Application\Actions;

use App\Infrastructure\Persistence\User\RepositoryInterface;
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
