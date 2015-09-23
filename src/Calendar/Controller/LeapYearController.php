<?php

namespace Calendar\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Calendar\Model\LeapYear;

class LeapYearController
{
    public function indexAction(Request $request,$year)
    {
        $leapyear = new LeapYear();
        if($leapyear->isLeapYear($year)){
            $response =  new Response('Yep, this is a leap year!'.rand());
        }else{
            $response = new Response('Nope, this is not a leap year.');
        }

        $response->setTtl(5);

//        $date = date_create_from_format('Y-m-d H:i:s','2015-10-15 10:00:00');
//        $response->setCache(array(
//            'public'=>true,
//            'etag'=>'abcde',
//            'last_modified'=>$date,
//            'max_age'=>10,
//            's_maxage'=>10,
//        ));
        //与下列方法等价
//        $response->setPublic();
//        $response->setEtag('abcde');
//        $response->setLastModified($date);
//        $response->setMaxAge(10);
//        $response->setSharedMaxAge(10);

//        $response->setETag('whatever_you_compute_as_an_etag');
//        if ($response->isNotModified($request)) {
//            return $response;
//        }
//        $response->setContent('The computed content of the response');

        return $response;
    }
}