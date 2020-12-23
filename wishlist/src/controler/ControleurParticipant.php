<?php

namespace wishlist\controler;

use Illuminate\Database\Eloquent\ModelNotFoundException;
use \Psr\Http\Message\ServerRequestInterface as Request;
use \Psr\Http\Message\ResponseInterface as Response;
use wishlist\model\Item;
use wishlist\view\VueParticipant;

class ControleurParticipant {

    private $c = null;

    public function __construct(\Slim\Container $p) {
        $this->c = $p;
    }

    public function displayItem(Request $rq, Response $rs, array $args):Response {
        try {
            $item = Item::query()->where('id', '=', $args['id'])->firstOrFail();
            /*
            $url = $this->c->router->pathFor('item', ['id'=>$args['id']]);

            $rs->getBody()->write("item : {$item->id} : <a href='$url'>{$item->nom}</a>");
            */
            $htmlvars = ['basepath'=> $rq->getUri()->getBasePath()];

            $v = new VueParticipant([$item],3);

            $rs->getBody()->write($v->render($htmlvars));

            return $rs;
        } catch (ModelNotFoundException $e) {
            $rs->getBody()->write("item {$item->id} non trouve");
            return $rs;
        }
    }
}