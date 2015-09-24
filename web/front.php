<?php

require_once __DIR__.'/../vendor/autoload.php';

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\EventListener\RouterListener;

use Symfony\Component\Routing\RequestContext;
use Symfony\Component\Routing\Matcher\UrlMatcher;

use Symfony\Component\HttpKernel\Controller\ControllerResolver;

use Symfony\Component\EventDispatcher\EventDispatcher;

use Symfony\Component\HttpKernel\Exception\FlattenException;
use Symfony\Component\HttpKernel\EventListener\ExceptionListener;

use Simplex\Framework;

$request = Request::createFromGlobals();

$routes = include __DIR__.'/../src/app.php';

$context = new RequestContext();
$matcher = new UrlMatcher($routes,$context);
$resolver = new ControllerResolver();

$dispatcher = new EventDispatcher();
$dispatcher->addSubscriber(new RouterListener($matcher));

//$listener = new ExceptionListener('Calendar\\Controller\\ErrorController');
//$dispatcher->addSubscriber($listener);
//$dispatcher->addSubscriber(new \Symfony\Component\HttpKernel\EventListener\ResponseListener('utf-8'));
//$dispatcher->addSubscriber(new \Symfony\Component\HttpKernel\EventListener\StreamedResponseListener());
$dispatcher->addSubscriber(new Simplex\StringResponseListener());

$framework = new Framework($dispatcher,$resolver);
$response = $framework->handle($request);
$response->send();

