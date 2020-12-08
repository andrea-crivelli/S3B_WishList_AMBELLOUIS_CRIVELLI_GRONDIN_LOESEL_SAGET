<?php

namespace wishlist\controler;

use http\Env\Request;
use http\Env\Response;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use wishlist\vue\VueParticipant;

class ControleurParticipant {

    private $c = null;

    public function __construct(\Slim\Container $p) {
        $this->c = $p;
    }

    public function displayItem(Request $rq, Response $rs, array $args):Response {
        try {
            $item = Item::query()->where('id', '=', $args['id'])->firstOrFail();

            $url = $this->c->router->pathFor('item', ['id'=>$args['id']]);

            $rs->getBody()->write("item : {$item->id} : <a href='$url'>{$item->nom}</a>");

            $htmlvars = ['basepath'=> $rq->getUri()->getBasePath()];

            $v = new VueParticipant([$item]);

            $rs->getBody()->write($v->render($htmlvars));

            return $rs;
        } catch (ModelNotFoundException $e) {

        }
    }
}