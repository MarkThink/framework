<?php

require_once __DIR__.'/../vendor/autoload.php';

use Symfony\Component\HttpFoundation\Request;

use Symfony\Component\Routing\RequestContext;
use Symfony\Component\Routing\Matcher\UrlMatcher;

use Symfony\Component\HttpKernel\Controller\ControllerResolver;

use Symfony\Component\EventDispatcher\EventDispatcher;

use Simplex\Framework;

$dispatcher = new EventDispatcher();
$dispatcher->addSubscriber(new Simplex\ContentLengthListener());
$dispatcher->addSubscriber(new Simplex\GoogleListener());

$request = Request::createFromGlobals();

$routes = include __DIR__.'/../src/app.php';

$context = new RequestContext();
$matcher = new UrlMatcher($routes,$context);
$resolver = new ControllerResolver();

$framework = new Framework($dispatcher,$matcher,$resolver);
$response = $framework->handle($request);

$response->send();

