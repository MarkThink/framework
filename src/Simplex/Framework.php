<?php

namespace Simplex;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Exception\ResourceNotFoundException;

use Symfony\Component\Routing\Matcher\UrlMatcherInterface;
use Symfony\Component\HttpKernel\Controller\ControllerResolverInterface;

use Symfony\Component\EventDispatcher\EventDispatcher;


class Framework
{
    protected $matcher;
    protected $resolver;
    protected $dispatcher;

    public function __construct(EventDispatcher $dispatcher,UrlMatcherInterface $matcher,ControllerResolverInterface $resolver)
    {
        $this->matcher = $matcher;
        $this->resolver = $resolver;
        $this->dispatcher = $dispatcher;
    }

    public function handle(Request $request)
    {
        $this->matcher->getContext()->fromRequest($request);

        try{
            $request->attributes->add($this->matcher->match($request->getPathInfo()));

            $controller = $this->resolver->getController($request);
            $arguments = $this->resolver->getArguments($request,$controller);

            $response = call_user_func_array($controller,$arguments);
        }catch (ResourceNotFoundException $e){
            return new Response('Not Found',404);
        }catch(\Exception $e){
            return new Response('An error occurred',500);
        }

        //dispatch a response event
        $this->dispatcher->dispatch('response',new ResponseEvent($response, $request));
        return $response;
    }
}