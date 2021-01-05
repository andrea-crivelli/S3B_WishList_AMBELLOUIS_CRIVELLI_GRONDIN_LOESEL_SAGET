<?php

namespace wishlist\controleurs;

use Slim\Container;


abstract class Controleur {
    protected $c;

    public function __construct(Container $container)
    {
        $this->c = $container;
    }
}