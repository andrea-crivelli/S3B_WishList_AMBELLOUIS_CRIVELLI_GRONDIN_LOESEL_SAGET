<?php

namespace wishlist\controleurs;

use wishlist\vues\VueAccueil;
use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Message\ResponseInterface as Response;

class ControleurPages extends Controleur {

    public function pagePrincipale(Request $rq, Response $rs, array $args): Response{
        $v = new VueAccueil([],$this->c);
        $rs->getBody()->write($v->render($args));
        return $rs;
    }
}