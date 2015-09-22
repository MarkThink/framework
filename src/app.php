<?php

use Symfony\Component\Routing\RouteCollection;
use Symfony\Component\Routing\Route;

$routes = new RouteCollection();

$routes->add('hello',new Route('/hello/{name}',array('name'=>'world','_controller'=>'render_template')));
$routes->add('bye',new Route('/bye'));

return $routes;