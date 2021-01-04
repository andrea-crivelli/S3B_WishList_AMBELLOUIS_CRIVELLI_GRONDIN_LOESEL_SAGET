<?php


namespace wishlist\controllers;


public abstract class Controller
{
    protected $view;
    protected $router;

    public function __construct(Container $container)
    {
        $this->view = $container->view;
        $this->router = $container->router;
    }
}