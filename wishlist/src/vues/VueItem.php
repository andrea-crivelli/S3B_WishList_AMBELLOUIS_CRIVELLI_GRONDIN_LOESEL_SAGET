<?php


namespace wishlist\vues;


class VueItem
{

    private $data;
    private $container;

    public function __construct($dt, $c)
    {
        $this->data=$dt;
        $this->container=$c;
    }

    public function render($vars) {


        $url_accueil = $this->container->router->pathFor('accueil');
        $url_listes = $this->container->router->pathFor('afficherListes');
        $url_creationl = $this->container->router->pathFor('creationListe');


    }
}