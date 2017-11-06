<?php

/**
 * Created by PhpStorm.
 * User: Emilien
 * Date: 06/11/2017
 * Time: 16:41
 */
namespace App\EventListener;

use Symfony\Component\HttpKernel\Event\GetResponseForExceptionEvent;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\HttpExceptionInterface;

class ExceptionListener
{
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
     * @param GetResponseForExceptionEvent $event
     */
    public function onKernelException(GetResponseForExceptionEvent $event)
    {
        $exception = $event->getException();
        $response  = new Response();

        if($exception instanceof HttpExceptionInterface && $exception->getStatusCode() === 404)
        {
            $template = $this->twig->render('error.html.twig',[
                'message' => 'Désolé, cette page n\'existe pas ! '
            ]);

            $response->setContent($template);
        }

        else
        {
            $template = $this->twig->render('error.html.twig',[
                'message' => 'Il semble que nous rencontrions des problèmes techniques pour faire aboutir votre demande. 
                Rafraichisser la page, si le problème persiste réessayer plus tard.'
            ]);

            $response->setContent($template);
        }

        $event->setResponse($response);
    }
}
