<?php

use Symfony\Component\Routing\RouteCollection;
use Symfony\Component\Routing\Route;

$routes = new RouteCollection();



$routes->add('hello',new Route('/hello/{name}',array(
    'name'=>'world',
    '_controller'=> function ($request) {
        $request->attributes->set('foo','bar');
        $response = render_template($request);
        $response->headers->set('Content-Type','text/plain');
        return $response;
    }
)));
$routes->add('bye',new Route('/bye'));

return $routes;