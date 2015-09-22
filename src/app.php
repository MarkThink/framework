<?php

use Symfony\Component\Routing\RouteCollection;
use Symfony\Component\Routing\Route;

$routes = new RouteCollection();

$routes->add('hello',new Route('/hello/{name}',array('name'=>'world')));
$routes->add('bye',new Route('/bye'));

return $routes;