<?php
require_once __DIR__ . '/vendor/autoload.php';
use Illuminate\Database\Capsule\Manager as DB;
use wishlist\model\Item;
use wishlist\model\Liste;
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
$app = new \Slim\App();


// ROUTES SLIM
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

$app->run();