<?php
/**
 * Created by PhpStorm.
 * User: Emilien
 * Date: 06/02/2018
 * Time: 22:40
 */

namespace App\Handler;


use App\Handler\Inter\ContactHandlerInterface;
use App\Services\Mails;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\HttpFoundation\Session\SessionInterface;

class ContactHandler implements ContactHandlerInterface
{
    private $mailService;

    private $session;

    public function __construct(
        Mails $mailService,
        SessionInterface $session
    )
    {
        $this->mailService = $mailService;
        $this->session     = $session;
    }

    public function handle(FormInterface $form)
    {
        if($form->isSubmitted() && $form->isValid())
        {
            $subject = $form->get('subject')->getData();
            $message = $this->mailService->contactMail(
                $form->get('fullname')->getData(),
                $form->get('email')->getData(),
                $subject === null ? 'Sujet non spécifié' : $subject,
                $form->get('message')->getData()
            );

            $this->session->getFlashBag()
                ->add('success',
                    'Message envoyé, nous vous répondrons au plus vite'
                )
            ;
            return $message;
        }

        return false;
    }
}