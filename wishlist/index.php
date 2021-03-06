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

///page pour faire des modifications
$app->get('/liste/modificationAjout/{tokencreation}[/]',ControleurListe::class.':afficherModifAjoutListe')->setName('modificationAjoutListe');

//afficher le formulaire de modification la liste
$app->get('/liste/modification/{tokencreation}[/]',ControleurListe::class.':afficherFormulaireModification')->setName('afficherFormulaireModification');
//modifier la liste
$app->post('/liste/modification/{tokencreation}[/]',ControleurListe::class.':modifierListe')->setName('modifierListe');

//afficher le formulaire de suppression la liste
$app->get('/liste/supression/{tokencreation}[/]',ControleurListe::class.':afficherFormulaireSuppression')->setName('afficherFormulaireSuppression');
//modifier la liste
$app->get('/liste/suppressionListe/{tokencreation}[/]',ControleurListe::class.':supprimerListe')->setName('supprimerListe');

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
$app->get('/item/{token}/reservationItem[/]', ControleurItem::class.':afficherFormulaire')->setName('afficherReservation');
//reservation d'un item
$app->post('/item/{token}/reservationItem[/]', ControleurItem::class.':reserverItem')->setName('reserverItem');

//affichage choix items a modifier
$app->get('/liste/{tokencreation}/modifierItem[/]',ControleurItem::class.':afficherChoixItemMod')->setName('choixModification');

//affichage formulaire modification item
$app->get('/liste/{tokencreation}/modifierItem/{id}[/]', ControleurItem::class.':afficherFormulaireItemModification')->setName('formulaireModificationItem');

//modification d'item avec le token creation (createur)
$app->post('/liste/{tokencreation}/modifierItem/{id}[/]', ControleurItem::class.':modifierItem')->setName('modificationItem');

//affichage choix items a supprimer
$app->get('/liste/{tokencreation}/supprimerItem[/]',ControleurItem::class.':afficherChoixItemSup')->setName('choixSuppression');

//affichage formulaire suppression item
$app->get('/liste/{tokencreation}/supprimerItem/{id}[/]', ControleurItem::class.':afficherFormulaireItemSuppression')->setName('formulaireSuppressionItem');
//suppression d'item avec le token creation (createur)
$app->get('/liste/{tokencreation}/supprimerLItem/{id}[/]', ControleurItem::class.':supprimerItem')->setName('suppressionItem');

$app->run();