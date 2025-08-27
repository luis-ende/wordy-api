<?php

declare(strict_types=1);

use App\Application\Actions\Api\CreateLearningUnitAction;
use App\Application\Actions\Api\CreateSentenceAction;
use App\Application\Actions\Api\ListLearningUnitsAction;
use App\Application\Actions\Api\ListSentenceAction;
use App\Application\Actions\User\ListUsersAction;
use App\Application\Actions\User\ViewUserAction;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Slim\App;
use Slim\Interfaces\RouteCollectorProxyInterface as Group;

return function (App $app) {
    $app->options('/{routes:.*}', function (Request $request, Response $response) {
        // CORS Pre-Flight OPTIONS Request Handler
        return $response;
    });

    $app->get('/', function (Request $request, Response $response) {
        $response->getBody()->write('Hello world!');
        return $response;
    });

    $app->group('/users', function (Group $group) {
        $group->get('', ListUsersAction::class);
        $group->get('/{id}', ViewUserAction::class);
    });

    $app->group('/api/v1', function (Group $group) {
        $group->get('/learning-units', ListLearningUnitsAction::class);
        $group->post('/learning-units', CreateLearningUnitAction::class);
        $group->get('/vocabulary', ListSentenceAction::class);
        $group->post('/vocabulary', CreateSentenceAction::class);
    });
};
