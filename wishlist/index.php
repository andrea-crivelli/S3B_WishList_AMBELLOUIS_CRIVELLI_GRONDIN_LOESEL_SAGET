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
$conf = ['settings' => [
    'displayErrorDetails' => true,
]];
$container = new \Slim\Container($conf);
$app = new \Slim\App($container);

// ROUTES SLIM

$app->get('/'               , ControleurPages::class.':pagePrincipale'  )->setName('accueil');
$app->get('/lists[/]'       , ControleurListe::class.':afficherListes'  )->setName('afficherListes');
$app->get('/lists/{token}[/]', ControleurListe::class.':afficherListe'  )->setName('afficherListe');
$app->post('createList[/]'  , ControleurListe::class.':creerListe'      )->setName('creationListe');

/**
$app->get('/lists/{id}/items[/]', function (Request $rq, Response $rs, array $args ){
    $rs->getBody()->write("Affichage des items de la liste {$args['id']}");
    $list = Liste::find($args['id']);
    $vue = new VueParticipant($list,2);
    print($vue->render(array()));
    return $rs;
})->setName('afficherItemsListe');



$app->get('/lists/{token:[a-zA-Z0-9]+[/]}', function (Request $request, Response $response, array $args){
    $control = new ControleurListe($this->container);
    return $control->getListe($request, $response, $args);
})->setName('afficherListe');

$app->get('/items/{id}[/]', function (Request $rq, Response $rs, array $args): Response {
   $c = new ControleurParticipant($this);
   return $c->displayItem($rq, $rs, $args);
})->setName('item');

**/
$app->run();