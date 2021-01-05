<?php

namespace wishlist\controllers;

use wishlist\view\VueAccueil;

class ControleurPages extends Controlleur{

    public function pagePrincipale(Request $rq, Response $rs, array $args): Response{
        $v = new VueAccueil($rs);
        $rs->getBody()->write($v->render($args));
        return $rs;
    }
}