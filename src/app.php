<?php

use Symfony\Component\Routing\RouteCollection;
use Symfony\Component\Routing\Route;
use Symfony\Component\HttpFoundation\Response;

class LeapYearController
{
    public function indexAction($request)
    {
        if(is_leap_year($request->attributes->get('year'))){
            return new Response('Yep, this is a leap year!');
        }
        return new Response('Nope, this is not a leap year.');
    }
}

function is_leap_year($year=null)
{
    if(null === $year){
        $year = data('Y');
    }
    return 0==$year % 400 || ( 0 == $year % 4 && 0 != $year %100);
}

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
$routes->add('leap_year',new Route('/is_leap_year/{year}',array(
    'year' => null,
    '_controller'=>array(
        new LeapYearController(),
        'indexAction'
    ),
)));

return $routes;