<?php

/**
 * Created by PhpStorm.
 * User: Emilien
 * Date: 01/11/2017
 * Time: 10:41
 */
namespace App\EventListener;

use Symfony\Component\HttpKernel\Event\GetResponseForExceptionEvent;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\HttpExceptionInterface;


class ExceptionListener
{

    /**
     * @var \Twig_Environment
     */
    private $twig;

    /**
     * ExceptionListener constructor.
     * @param \Twig_Environment $twig
     */
    public function __construct(\Twig_Environment $twig)
    {
        $this->twig = $twig;
    }

    /**
     * catch errors and display custom template
     * @param GetResponseForExceptionEvent $event
     */
    public function onKernelException(GetResponseForExceptionEvent $event)
    {
        $exception = $event->getException();

        $response = new Response();

        switch (true){
            case($exception instanceof HttpExceptionInterface && $exception->getStatusCode() === 404):
                $response->setContent(
                           $this->twig
                                ->render('error.html.twig',[
                                    'message' => 'Cette page n\'existe pas.'
                                ]
                           )
                );
                break;
            case($exception instanceof HttpExceptionInterface && $exception->getStatusCode() === 403):
                $response->setContent(
                          $this->twig
                               ->render('error.html.twig',[
                                    'message' => 'Vous n\'êtes pas autorisé à accéder à ce contenu !'
                               ]
                          )
                );
                break;
            default:$response->setContent(
                               $this->twig
                                    ->render('error.html.twig',[
                                         'message' => 'Nous rencontrons actuellement des problèmes techniques. Réessayez plus tard :)'
                                    ]
                               )
            );
        }
        return $event->setResponse($response);
    }
}

