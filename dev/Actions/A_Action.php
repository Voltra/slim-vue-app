<?php
namespace App\Actions;


use Slim\Container;

abstract class A_Action {
    /**
     * @var Container
     */
    protected $container;

    public function __construct(Container $container) {
        $this->container = $container;
    }
}