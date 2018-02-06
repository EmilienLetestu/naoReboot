<?php
/**
 * Created by PhpStorm.
 * User: Emilien
 * Date: 06/02/2018
 * Time: 09:51
 */

namespace App\Action;

use App\Form\ContactForm;

use App\Handler\ContactHandler;
use App\Responder\AboutUsResponder;
use App\Services\Mails;
use Symfony\Component\Form\FormFactoryInterface;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Session\SessionInterface;

class AboutUsAction
{
    /**
     * @var FormFactoryInterface
     */
    private $formFactory;

    /**
     * @var \Swift_Mailer
     */
    private $swift;

    /**
     * @var ContactHandler
     */
    private $contactHandler;

    /**
     * AboutUsAction constructor.
     * @param FormFactoryInterface $formFactory
     * @param \Swift_Mailer $swift
     * @param ContactHandler $contactHandler
     */
    public function  __construct(
        FormFactoryInterface $formFactory,
        \Swift_Mailer        $swift,
        ContactHandler       $contactHandler

    )
    {
        $this->formFactory    = $formFactory;
        $this->swift          = $swift;
        $this->contactHandler = $contactHandler;
    }

    /**
     * @param Request $request
     * @param AboutUsResponder $responder
     * @return RedirectResponse|\Symfony\Component\HttpFoundation\Response
     */
    public function __invoke(Request $request, AboutUsResponder $responder)
    {
        $form = $this->formFactory
                     ->create(ContactForm::class)
                     ->handleRequest($request)
        ;

        $handler = $this->contactHandler->handle($form);

        if($handler)
        {
            $this->swift->send($handler);

            return new RedirectResponse('/accueil');
        }

        return $responder(
            $form->createView()
        );
    }
}
