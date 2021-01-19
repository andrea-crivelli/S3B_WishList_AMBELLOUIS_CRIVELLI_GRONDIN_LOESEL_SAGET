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
$app->get('/liste/{token}[/]', ControleurListe::class . ':afficherListe')->setName('afficherListe');

//ajout du message et redirection vers l'affichage
$app->post('/liste/{token}[/]', ControleurListe::class . ':creerMessageListe')->setName('creerMessageListe');

//affichage formulaire de creation
$app->get('/creationListe[/]', ControleurListe::class . ':afficherFormulaire')->setName('afficherFormulaireCreation');
//creation de liste
$app->post('/creationListe[/]', ControleurListe::class . ':creerListe')->setName('creationListe');

//affichage page de validation de creation
$app->get('/creationListe/validation/{tokencreation}/{token}[/]',ControleurListe::class.':afficherPageValidation')->setName('validationCreation');

//choisir entre ajouter des items ou modifier la liste
$app->get('/liste/modificationAjout/{tokencreation}[/]',ControleurListe::class.':afficherModifAjoutListe')->setName('modificationAjoutListe');

//afficher le formulaire de modification la liste
$app->get('/liste/modification/{tokencreation}[/]',ControleurListe::class.':afficherFormulaireModification')->setName('afficherFormulaireModification');
//modifier la liste
$app->post('/liste/modification/{tokencreation}[/]',ControleurListe::class.':modifierListe')->setName('modifierListe');

/**
 * Routes concernant les items
 */
//affichage d'un item avec token
$app->get('/item/{token}', ControleurItem::class . ':afficherItem')->setName('afficherItem');

//affichage du formulaire d'ajout d'item
$app->get('/liste/{tokencreation}/ajouterItem[/]', ControleurItem::class.':afficherFormulaireItem')->setName('formulaireItem');
//ajout d'item avec le token creation (createur)
$app->post('/liste/{tokencreation}/ajouterItem[/]', ControleurItem::class.':creerItem')->setName('creationItem');

//affichage formulaire reservation item
$app->get('/reservationItem[/]', ControleurItem::class.'afficherFormulaire')->setName('afficherReservation');
//reservation de l'item
$app->post('/reservationItem[/]', ControleurItem::class.'reserverItem')->setName('reserverItem');

//affichage formulaire modification item
$app->get('/liste/{tokencreation}/modifierItem[/]', ControleurItem::class.':afficherFormulaireItemModification')->setName('formulaireItem');
//ajout d'item avec le token creation (createur)
$app->post('/liste/{tokencreation}/modifierItem[/]', ControleurItem::class.':modifierItem')->setName('creationItem');

$app->run();