<?php

declare(strict_types=1);

use App\Application\Actions\Testes\ListCarsAction;
use App\Application\Actions\Testes\OlaAction;
use App\Application\Actions\Testes\OlaGetAction;
use App\Application\Actions\Testes\OlaPostAction;

#ap3_pi2

use App\Application\Actions\Gymlog\regAction;
use App\Application\Actions\Gymlog\logAction;
use App\Application\Actions\Gymlog\logOutAction;
use App\Application\Actions\Gymlog\exerciseGetAction;
use App\Application\Actions\Gymlog\planGetAction;
use App\Application\Actions\Gymlog\planAddAction;
use App\Application\Actions\Gymlog\removePlanAction;
use App\Application\Actions\Gymlog\getExerciseUserAction;
use App\Application\Actions\Gymlog\addExePlanUserAction;
use App\Application\Actions\Gymlog\removeExePlanUserAction;
use App\Application\Actions\Gymlog\increaseSeriesExeAction;

#ap3_pi2 TERMINOU

use App\Application\Actions\Users\LoginAction;

use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Slim\App;

use Slim\Interfaces\RouteCollectorProxyInterface as Group;

return function (App $app) {
    $app->options('/{routes:.*}', function (Request $request, Response $response) {
        // CORS Pre-Flight OPTIONS Request Handler
        return $response;
    });
    

    // Endpoint em que apenas é devolvida uma mensagem em texto 
    $app->get('/hello', function (Request $request, Response $response) {
        $response->getBody()->write('Hello world!');
        return $response;
    });

    #ap3_pi2
    $app->post('/reg', regAction::class);
    $app->patch('/log', logAction::class);
    $app->patch('/logOut', logOutAction::class);
    $app->get('/getExer', exerciseGetAction::class);
    $app->get('/getPlanUser', planGetAction::class);
    $app->post('/addPlanUser', planAddAction::class);
    $app->delete('/remPlan',removePlanAction::class);
    $app->get('/getExeUser',getExerciseUserAction::class);
    $app->post('/addExePlanUser',addExePlanUserAction::class);   
    $app->delete('/remExePlanUser',removeExePlanUserAction::class); 
    $app->patch('/increaseSeries',increaseSeriesExeAction::class);
    #ap3_pi2 TERMINOU

    // Endpoint em que apenas é devolvida uma mensagem em texto 
    // mas processado por uma classe separada
    $app->get('/hello2', OlaAction::class);

    $app->get('/helloget/{name}', OlaGetAction::class);

    $app->post('/hellopost', OlaPostAction::class);   

    // Endpoint com um acesso à Base de Dados
    $app->get('/testebd', function (Request $request, Response $response) {
        
        // Pode fazer diretamente as acções aqui, no entanto, 
        // para tornar o código mais legível e organizado
        // é preferível recorrer à forma associado ao endpoint /teste2

        $db = $this->get(PDO::class);
        $sth = $db->prepare("SELECT * FROM PESSOA");
        $sth->execute();
        $data = $sth->fetchAll(PDO::FETCH_ASSOC);
        $payload = json_encode($data);
        $response->getBody()->write($payload);
        return $response->withHeader('Content-Type', 'application/json');
    });

     // Endpoint com um acesso à Base de Dados
    // mas processado por uma classe separada
    $app->get('/testebd2', ListCarsAction::class);     

    $app->post('/user/login', LoginAction::class);

/*
    $app->group('/users', function (Group $group) {
        $group->get('', ListUsersAction::class);
        $group->get('/{id}', ViewUserAction::class);
    });
*/

};
