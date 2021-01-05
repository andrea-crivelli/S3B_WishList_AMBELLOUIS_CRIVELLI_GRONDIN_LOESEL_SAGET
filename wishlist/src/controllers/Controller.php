<?php


namespace wishlist\controllers;


abstract class Controller
{
    protected $view;
    protected $router;

    public function __construct(Container $container)
    {
        $this->view = $container->view;
        $this->router = $container->router;
    }
}