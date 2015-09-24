<?php

require_once __DIR__.'/../vendor/autoload.php';

use Symfony\Component\HttpFoundation\Request;

$request = Request::createFromGlobals();

$routes = include __DIR__.'/../src/app.php';

$sc = include __DIR__.'/../src/container.php';
$sc->setParameter('routes',$routes);
$sc->setParameter('charset','utf-8');
$sc->setParameter('debug',true);

$response = $sc->get('framework')->handle($request);

$response->send();

