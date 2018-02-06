<?php
/**
 * Created by PhpStorm.
 * User: Emilien
 * Date: 06/02/2018
 * Time: 09:51
 */

namespace App\Action;

use App\Form\ContactForm;

use App\Responder\AboutUsResponder;
use App\Services\Mails;
use Symfony\Component\Form\FormFactoryInterface;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Session\SessionInterface;

class AboutUsAction
{
    private $formFactory;
    private $mailService;
    private $swift;
    private $session;

    /**
     * ContactAction constructor.
     * @param FormFactoryInterface $formFactory
     * @param Mails $mailService
     * @param \Swift_Mailer $swift
     * @param SessionInterface $session
     */
    public function  __construct(
        FormFactoryInterface $formFactory,
        Mails                $mailService,
        \Swift_Mailer        $swift,
        SessionInterface     $session

    )
    {
        $this->formFactory  = $formFactory;
        $this->mailService  = $mailService;
        $this->swift        = $swift;
        $this->session      = $session;
    }

    /**
     * @param Request $request
     * @param AboutUsResponder $responder
     * @return RedirectResponse|\Symfony\Component\HttpFoundation\Response
     */
    public function __invoke(Request $request, AboutUsResponder $responder)
    {
        $contactForm = $this->formFactory->create(ContactForm::class);
        $contactForm->handleRequest($request);

        if($contactForm->isSubmitted() && $contactForm->isValid())
        {
            $subject = $contactForm->get('subject')->getData();
            $message = $this->mailService->contactMail(
                $contactForm->get('fullname')->getData(),
                $contactForm->get('email')->getData(),
                $subject === null ? 'Sujet non spécifié' : $subject,
                $contactForm->get('message')->getData()
            );
            $this->swift->send($message);

            $this->session->getFlashBag()
                ->add('success',
                    'Message envoyé, nous vous répondrons au plus vite'
                )
            ;
            return new RedirectResponse('/accueil');
        }

        return $responder(
            $contactForm->createView()
        );
    }
}
