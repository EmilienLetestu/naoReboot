<?php
/**
 * Created by PhpStorm.
 * User: Emilien
 * Date: 23/11/2017
 * Time: 14:51
 */

namespace App\Services;


use App\Form\ContactForm;
use Symfony\Component\Form\FormFactory;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Session\Session;

class Contact
{
    private $formFactory;
    private $mailService;
    private $swift;
    private $session;

    /**
     * Contact constructor.
     * @param FormFactory $formFactory
     * @param Mails $mailService
     * @param \Swift_Mailer $swift
     * @param Session $session
     */
    public function  __construct(
        FormFactory     $formFactory,
        Mails           $mailService,
        \Swift_Mailer   $swift,
        Session         $session

    )
    {
        $this->formFactory  = $formFactory;
        $this->mailService  = $mailService;
        $this->swift        = $swift;
        $this->session      = $session;
    }

    /**
     * @param Request $request
     * @return \Symfony\Component\Form\FormView
     */
    public function processContact(Request $request)
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
            return $contactForm->createView();
        }

        return $contactForm->createView();
    }

}
