<?php
require_once __DIR__ . '/src/vendor/autoload.php';
use Illuminate\Database\Capsule\Manager as DB;

use wishlist\modeles\Item;
use wishlist\modeles\Liste;
use wishlist\controleurs\ControleurParticipant;
use wishlist\controleurs\ControleurListe;
use wishlist\vues\VueParticipant;
use \wishlist\controleurs\ControleurPages;

use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Message\ResponseInterface as Response;

//BASE DE DONNEES
$db=new DB();
$config=parse_ini_file(__DIR__ . '/conf/db.config.ini');
if ($config) $db->addConnection($config);
$db->setAsGlobal();
//demarrer eloquent
$db->bootEloquent();


// SLIM
$c = new \Slim\Container(['settings'=>['displayErrorDetails' => true]]);
$app = new \Slim\App($c);
$cont = $app->getContainer();


// ROUTES SLIM
$app->get('/' ,function (Request $rq, Response $rs, array $args ) use ($cont){
    $control = new ControleurPages($cont);
    return $control->pagePrincipale($rq, $rs, $args);
})->setName('accueil');

$app->post('/create/list[/]', function (Request $request, Response $response, array $args) use ($cont) {
    $control = new ControleurListe($cont);
    return $cont->createListe($request, $response, $args);
})->setName('creationListe');

$app->get('/lists/{token:[a-zA-Z0-9]+[/]}', function (Request $request, Response $response, array $args) use ($cont) {
    $control = new ControleurListe($cont);
    return $cont->getListe($request, $response, $args);
})->setName('afficherListe');

$app->get('/items/{id}[/]', function (Request $rq, Response $rs, array $args): Response {
   $c = new ControleurParticipant($this);
   return $c->displayItem($rq, $rs, $args);
})->setName('item');

$app->get('/lists[/]', function (Request $rq, Response $rs, array $args ): Response {
    /*$rs->getBody()->write("Affichage de la liste des listes");
    $listl = Liste::all();
    $vue = new VueParticipant($listl,1);
    $rs->getBody()->write($vue->__render(array()));*/
    return $rs;
});

$app->get('/lists/{id}/items[/]', function (Request $rq, Response $rs, array $args ): Response {
    /*$rs->getBody()->write("Affichage des items de la liste {$args['id']}");
    $list = Liste::find($args['id']);
    $vue = new VueParticipant($list,2);
    print($vue->render(array()));*/
    return $rs;
});


$app->run();