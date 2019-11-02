<?php

use Slim\Http\Request;
use Slim\Http\Response;

$container = $app->getContainer();

$app->get('/procesos', function (Request $request, Response $response, array $args)   {
    $procesos=new \Entidad\Proceso_model();
    return $response->withJson($procesos->GetAll('"/proceso/"')->result);
});

$app->post('/proceso', function (Request $request, Response $response) {
    $proceso = new Entidad\Proceso_model();
    return $response->withJson($proceso->InsertOrUpdate($request->getParsedBody()));
});

$app->get('/proceso', function (Request $request, Response $response) use($container) {
    $macroprocesos= new \Entidad\Macroproceso_model();
    $selMacro= $macroprocesos->GetAll();
    $responsables= new \Entidad\Responsable_model();
    $selResp= $responsables->GetAll();
    $args = array('macroprocesos'=>$selMacro->result, 'responsables'=>$selResp->result);
    return $container->get('renderer')->render($response, 'addproceso.phtml', $args);
});
$app->get('/proceso/{id}', function (Request $request, Response $response,$args) use($container) {
    $procesos=new \Entidad\Proceso_model();
    return $response->withJson($procesos->Get($args['id'])->result);
});
