<?php
require_once __DIR__ . '/src/vendor/autoload.php';

use Illuminate\Database\Capsule\Manager as DB;

use wishlist\modeles\Item;
use wishlist\modeles\Liste;
use wishlist\controleurs\ControleurParticipant;
use wishlist\controleurs\ControleurListe;
use wishlist\controleurs\ControleurItem;
use wishlist\vues\VueParticipant;
use \wishlist\controleurs\ControleurPages;

use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Message\ResponseInterface as Response;

//BASE DE DONNEES
$db = new DB();
$config = parse_ini_file(__DIR__ . '/conf/db.config.ini');
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

//page d'accueil
$app->get('/', ControleurPages::class . ':pagePrincipale')->setName('accueil');
//affichage listes publiques
$app->get('/liste[/]', ControleurListe::class . ':afficherListes')->setName('afficherListes');
/**
 * Routes concernant les listes
 */
//affichage d'une liste avec token (participant)
$app->get('/liste/{token}', ControleurListe::class . ':afficherListe')->setName('afficherListe');

//affichage formulaire de creation
$app->get('/creationListe[/]', ControleurListe::class . ':afficherFormulaire')->setName('afficherFormulaireCreation');
//creation de liste
$app->post('/creationListe[/]', ControleurListe::class . ':creerListe')->setName('creationListe');

//affichage page de validation de creation
$app->get('/creationListe/validation/{tokencreation}/{token}/',ControleurListe::class.':afficherPageValidation')->setName('validationCreation');

//choisir entre ajouter des items ou modifier la liste
$app->get('/liste/modificationAjout/{tokencreation}[/]',ControleurListe::class.':afficherModifAjoutListe')->setName('modificationAjoutListe');

//modifier la liste
$app->get('/liste/modification/{tokencreation}',ControleurListe::class.':modifierListe')->setName('modifierListe');
/**
 * Routes concernant les items
 */
//affichage d'un item avec token
$app->get('/item/{token}', ControleurItem::class . ':afficherItem')->setName('afficherItem');

//affichage du formulaire d'ajout d'item
$app->get('/liste/{tokencreation}/ajouterItem', ControleurItem::class.':afficherFormulaireItem')->setName('formulaireItem');
//ajout d'item avec le token creation (createur)
$app->post('/liste/{tokencreation}/ajouterItem', ControleurItem::class.':creerItem')->setName('creationItem');

//$app->get('/item/', ControleurItem::class.':afficherItem')->setName('afficherItem');







/**
 * $app->get('/lists/{id}/items[/]', function (Request $rq, Response $rs, array $args ){
 * $rs->getBody()->write("Affichage des items de la liste {$args['id']}");
 * $list = Liste::find($args['id']);
 * $vue = new VueParticipant($list,2);
 * print($vue->render(array()));
 * return $rs;
 * })->setName('afficherItemsListe');
 *
 *
 *
 * $app->get('/lists/{token:[a-zA-Z0-9]+[/]}', function (Request $request, Response $response, array $args){
 * $control = new ControleurListe($this->container);
 * return $control->getListe($request, $response, $args);
 * })->setName('afficherListe');
 *
 * $app->get('/items/{id}[/]', function (Request $rq, Response $rs, array $args): Response {
 * $c = new ControleurParticipant($this);
 * return $c->displayItem($rq, $rs, $args);
 * })->setName('item');
 **/
$app->run();