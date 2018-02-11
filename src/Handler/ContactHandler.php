<?php
/**
 * Created by PhpStorm.
 * User: Emilien
 * Date: 06/02/2018
 * Time: 22:40
 */

namespace App\Handler;


use App\Handler\Interfaces\ContactHandlerInterface;
use App\Services\Mails;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\HttpFoundation\Session\SessionInterface;

class ContactHandler implements ContactHandlerInterface
{
    /**
     * @var Mails
     */
    private $mailService;


    /**
     * @var \Swift_Mailer
     */
    private $swift;

    /**
     * ContactHandler constructor.
     * @param Mails $mailService
     * @param \Swift_Mailer $swift
     */
    public function __construct(
        Mails            $mailService,
        \Swift_Mailer    $swift
    )
    {
        $this->mailService = $mailService;
        $this->swift       = $swift;
    }

    /**
     * @param FormInterface $form
     * @return bool
     */
    public function handle(FormInterface $form):bool
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

            $this->swift->send($message);

            return true;
        }

        return false;
    }
}
