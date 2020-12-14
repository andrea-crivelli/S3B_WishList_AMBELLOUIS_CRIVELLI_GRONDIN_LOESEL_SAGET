<?php
require_once __DIR__ . '/src/vendor/autoload.php';
use Illuminate\Database\Capsule\Manager as DB;

use wishlist\model\Item;
use wishlist\model\Liste;
//use wishlist\controler\ControleurParticipant;
use wishlist\vue\VueParticipant;

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


// ROUTES SLIM

/**$app->get('/items/{id}[/]', function (Request $rq, Response $rs, array $args): Response {
   $c = new ControleurParticipant($this);
   return $c->displayItem($rq, $rs, $args);
})->setName('item'); **/

$app->get('/' ,function (Request $rq, Response $rs, array $args ): Response {
    $rs->getBody()->write("Page principale");
    return $rs;
}
);

$app->get('/lists[/]', function (Request $rq, Response $rs, array $args ): Response {
    $rs->getBody()->write("Affichage de la liste des listes");
    return $rs;
}
);

$app->get('/lists/{id}/items[/]', function (Request $rq, Response $rs, array $args ): Response {
    $rs->getBody()->write("Affichage des items de la liste {$args['id']}");
    return $rs;
}
);

//TESTS

// pour afficher la liste des listes de souhaits
$listl = Liste::all();
$vue = new VueParticipant($listl->toArray());
$vue->affichage(1);
// pour afficher 1 item
$item = Item::find(3);
$vue = new VueParticipant([$item]);
$vue->affichage(3);


// RUN
$app->run();