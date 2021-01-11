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

    }
}