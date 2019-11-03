<?php

use Slim\Http\Request;
use Slim\Http\Response;

$container = $app->getContainer();

$app->get('/macroprocesos', function (Request $request, Response $response, array $args)   {
    $procesos=new \Entidad\Macroproceso_model();
    return $response->withJson($procesos->GetAll('"/macroproceso/"')->result);
});

$app->get('/macroprocesos/html', function (Request $request, Response $response) use($container) {
    $dat = new \Entidad\Macroproceso_model();
    $datos = json_encode($dat->GetAll('"/macroproceso/"')->result);
    $args = array('datos'=>$datos, 'urlData'=>'/macroprocesos/bootgrid', 'titulo'=>'Macroprocesos');
    return $container->get('renderer')->render($response, 'grilla.phtml', $args);
});

$app->get('/macroprocesos/bootgrid', function (Request $request, Response $response) use($container) {
    $procesos = new \Entidad\Macroproceso_model();
    return $response->withJson($procesos->GetAllBootgrid('"/macroproceso/"'));
});


$app->post('/macroproceso', function (Request $request, Response $response) {
    $proceso = new \Entidad\Macroproceso_model();
    return $response->withJson($proceso->InsertOrUpdate($request->getParsedBody()));
});

$app->get('/macroproceso', function (Request $request, Response $response) use($container) {
    $grupos[0]['id']=1;
    $grupos[0]['name']='Estrategico';
    $grupos[1]['id']=2;
    $grupos[1]['name']='Operacional';
    $grupos[2]['id']=3;
    $grupos[2]['name']='Soporte';

    $args = array('grupos'=>$grupos);
    return $container->get('renderer')->render($response, 'addmacro.phtml', $args);
});
$app->get('/macroproceso/{id}', function (Request $request, Response $response,$args) use($container) {
    $proceso = new \Entidad\Macroproceso_model();
    return $response->withJson($proceso->Get($args['id'])->result);
});
