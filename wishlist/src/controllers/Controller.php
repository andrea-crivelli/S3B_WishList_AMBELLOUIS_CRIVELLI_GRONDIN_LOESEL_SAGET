<?php


namespace wishlist\controllers;


use Slim\Container;

abstract class Controller
{
    protected $c;

    public function __construct(Container $container)
    {
        $this->c = $container;
    }
}