<?php

namespace wishlist\controllers;

use wishlist\view\VueAccueil;
use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Message\ResponseInterface as Response;

class ControleurPages extends Controller{

    public function pagePrincipale(Request $rq, Response $rs, array $args): Response{
        $v = new VueAccueil($rs);
        $rs->getBody()->write($v->render($args));
        return $rs;
    }
}