<?php

require_once __DIR__.'/../vendor/autoload.php';

use Symfony\Component\HttpFoundation\Request;

use Symfony\Component\Routing\RequestContext;
use Symfony\Component\Routing\Matcher\UrlMatcher;

use Symfony\Component\HttpKernel\Controller\ControllerResolver;

use Symfony\Component\EventDispatcher\EventDispatcher;

use Simplex\Framework;

$dispatcher = new EventDispatcher();
$dispatcher->addListener('response',function(Simplex\ResponseEvent $event){
    $response = $event->getResponse();

    if($response->isRedirection()
        || ($response->headers->has('Content-Type') && false === strpos($response->headers->get('Content-Type'), 'html'))
        || 'html' !== $event->getRequest()->getRequestFormat()
    ){
        return;
    }

    $response->setContent($response->getContent().'GA CODE');
},0);

$dispatcher->addListener('response', function (Simplex\ResponseEvent $event) {
    $response = $event->getResponse();
    $headers = $response->headers;

    if (!$headers->has('Content-Length') && !$headers->has('Transfer-Encoding')) {
        $headers->set('Content-Length', strlen($response->getContent()));
    }
},1);

$request = Request::createFromGlobals();

$routes = include __DIR__.'/../src/app.php';

$context = new RequestContext();
$matcher = new UrlMatcher($routes,$context);
$resolver = new ControllerResolver();

$framework = new Framework($dispatcher,$matcher,$resolver);
$response = $framework->handle($request);

$response->send();

