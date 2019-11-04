<?php

use Slim\Http\Request;
use Slim\Http\Response;

$container = $app->getContainer();

$app->get('/grupos', function (Request $request, Response $response, array $args)   {
    $procesos=new \Entidad\Grupo_model();
    return $response->withJson($procesos->GetAll('"/grupo/"')->result);
});

$app->get('/grupos/html', function (Request $request, Response $response) use($container) {
    $dat = new \Entidad\Grupo_model();
    $datos = json_encode($dat->GetAll('"/grupo/"')->result);
    $th= (array)$dat->GetAll('"/grupo/"')->result[0];
    $th = array_keys($th);
    $args = array(  'datos'=>$datos,
                    'urlData'=>'/grupos/bootgrid',
                    'titulo'=>'Grupos',
                    'th'=> $th,
                    'linkAdd'=>'/grupo');
    return $container->get('renderer')->render($response, 'grilla.phtml', $args);
});

$app->get('/grupos/bootgrid', function (Request $request, Response $response) use($container) {
    $procesos = new \Entidad\Grupo_model();
    return $response->withJson($procesos->GetAllBootgrid('"/grupo/"'));
});


$app->post('/grupo', function (Request $request, Response $response) {
    $proceso = new \Entidad\Grupo_model();
    return $response->withJson($proceso->InsertOrUpdate($request->getParsedBody()));
});

$app->get('/grupo', function (Request $request, Response $response) use($container) {
    $grupos[0]['id']=1;
    $grupos[0]['name']='Estrategico';
    $grupos[1]['id']=2;
    $grupos[1]['name']='Operacional';
    $grupos[2]['id']=3;
    $grupos[2]['name']='Soporte';

    $args = array('grupos'=>$grupos);
    $args = array();
    return $container->get('renderer')->render($response, 'addgrupo.phtml', $args);
});
$app->get('/grupo/{id}', function (Request $request, Response $response,$args) use($container) {
    $proceso = new \Entidad\Grupo_model();
    return $response->withJson($proceso->Get($args['id'])->result);
});
