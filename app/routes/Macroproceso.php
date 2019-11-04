<?php

use Slim\Http\Request;
use Slim\Http\Response;

$container = $app->getContainer();

$app->get('/macroprocesos/[{formato}]', function (Request $request, Response $response, $param) use($container) {
    $dat = new \Entidad\Macroproceso_model();
    if(isset($param['formato'])){
        switch ($param['formato']) {
            case 'html':
                $datos = json_encode($dat->GetAll('"/macroproceso/"')->result);
                $th = (array)$dat->GetAll('"/macroproceso/"')->result[0];
                $th = array_keys($th);
                $args = array('datos' => $datos,
                    'urlData' => '/macroprocesos/bootgrid',
                    'titulo' => 'Macroprocesos',
                    'th' => $th,
                    'linkAdd' => '/macroproceso'
                );
                return $container->get('renderer')->render($response, 'grilla.phtml', $args);
                break;
            case 'bootgrid':
                return $response->withJson($dat->GetAllBootgrid('"/macroproceso/"'));
                break;
            default:
                return $response->withJson($dat->GetAll('"/macroproceso/"')->result);
        }
    }else{
        return $response->withJson($dat->GetAll('"/macroproceso/"')->result);
    };
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
