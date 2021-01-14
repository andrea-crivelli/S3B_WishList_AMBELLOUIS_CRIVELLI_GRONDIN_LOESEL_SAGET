<?php

namespace wishlist\controleurs;
use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Message\ResponseInterface as Response;
use wishlist\modeles\Item;
use wishlist\vues\VueItem;


class ControleurItem extends Controleur {

    public function afficherItem(Request $rq, Response $rs, array $args): Response{
        $item = Item::where('id', '=', $args['id'])->first();
        $vue = new VueItem($item, $this->c);
        $rs->getBody()->write($vue->render(1));
        return $rs;
    }
}