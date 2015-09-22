<?php

require_once __DIR__.'/../vendor/autoload.php';

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

use Symfony\Component\Routing\RequestContext;
use Symfony\Component\Routing\Matcher\UrlMatcher;
use Symfony\Component\Routing\Exception\ResourceNotFoundException;
use Symfony\Component\Routing\Generator\UrlGenerator;
use Symfony\Component\Routing\Matcher\Dumper\PhpMatcherDumper;

$request = Request::createFromGlobals();

$routes = include __DIR__.'/../src/app.php';

$context = new RequestContext();
$context->fromRequest($request);
$matcher = new UrlMatcher($routes,$context);

//print_r($matcher->match('/bye'));
//print_r($matcher->match('/hello/Fabien'));
//print_r($matcher->match('/hello'));
//$matcher->match('/not-found');

//$generator = new UrlGenerator($routes, $context);
//$url =  $generator->generate('hello', array('name' => 'Fabien'));
//$url_abs = $generator->generate('hello', array('name' => 'Fabien'),true);

//创建优化的类替换默认的UrlMatcher 以提升性能
//$dumper = new PhpMatcherDumper($routes);
//$dump_routes = $dumper->dump();

function render_template($request)
{
	extract($request->attributes->all(),EXTR_SKIP);
	ob_start();
	include sprintf(__DIR__.'/../src/pages/%s.php',$_route);
	return new Response(ob_get_clean());
}

try{
	$request->attributes->add($matcher->match($request->getPathInfo()));
	$response = call_user_func('render_template',$request);
}catch (ResourceNotFoundException $e){
	$response = new Response('Not Found',404);
}catch(\Exception $e){
	$response = new Response('An error occurred',500);
}


$response->send();