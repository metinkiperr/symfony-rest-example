<?php

namespace AppBundle\EventListener;


use AppBundle\Api\ApiProblem;
use AppBundle\Api\ApiProblemException;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpKernel\Event\GetResponseForExceptionEvent;
use Symfony\Component\HttpKernel\Exception\HttpExceptionInterface;
use Symfony\Component\HttpKernel\KernelEvents;
use Symfony\Component\HttpFoundation\JsonResponse;

class ApiExceptionSubscriber implements EventSubscriberInterface
{

    /**
     * @var
     */
    private $debug;

    public function __construct($debug)
    {
        $this->debug = $debug;
    }

    public static function getSubscribedEvents()
    {
        return array(KernelEvents::EXCEPTION => 'onKernelException');
    }

    public function onKernelException(GetResponseForExceptionEvent $event)
    {

        //if the exception is not occured in api, do not make it json
        if (strpos($event->getRequest()->getPathInfo(), '/api') !== 0){
            return;
        }


        $e = $event->getException();
        $statusCode = $e instanceof HttpExceptionInterface ? $e->getStatusCode() : 500;

        if ($statusCode == 500 && $this->debug){
            return;
        }

        if ($e instanceof ApiProblemException){
            $apiProblem = $e->getApiProblem();
        }
        else{
            $apiProblem = new ApiProblem($statusCode);
            if ($e instanceof HttpExceptionInterface){
                $apiProblem->set('detail', $e->getMessage());
            }
        }

        $data = $apiProblem->toArray();
        if ($data['type'] != 'about:blank'){
            //todo: change this when you made the documentation page
            $data['type'] = 'http://localhost:8000/docs/errors#'.$data['type'];
        }

        $response =  new JsonResponse(
            $data,
            $apiProblem->getStatusCode()
        );
        $response->headers->set('Content-Type', "application/problem+json");
        $event->setResponse($response);
    }

}