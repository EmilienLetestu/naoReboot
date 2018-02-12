<?php
/**
 * Created by PhpStorm.
 * User: Emilien
 * Date: 07/02/2018
 * Time: 14:06
 */

namespace App\Handler;


use App\Entity\User;
use App\Handler\Interfaces\AskResetHandlerInterface;
use App\Services\Mails;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\HttpFoundation\Session\SessionInterface;

class AskResetHandler implements AskResetHandlerInterface
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
     * @var SessionInterface
     */
    private $session;

    /**
     * AskResetHandler constructor.
     * @param Mails $mailService
     * @param SessionInterface $session
     */
    public function __construct(
        Mails            $mailService,
        \Swift_Mailer    $swift,
        SessionInterface $session
    )
    {
        $this->mailService = $mailService;
        $this->swift       = $swift;
        $this->session     = $session;
    }

    /**
     * @param FormInterface $form
     * @param User $user
     * @return bool
     */
    public function handle(FormInterface $form, User $user):bool
    {
        if($form->isSubmitted() && $form->isValid())
        {
            //check if mail exist
            $user = $this->mailService
                         ->checkMailAvailability($user->getEmail())
            ;

            if(!$user)
            {
                $this->session->getFlashBag()
                    ->add('denied',
                        'Adresse e-mail inconnue'
                    )
                ;
                return false;
            }
            //prepare email
            $message = $this->mailService->resetPswdMail(
                $user->getName(),
                $user->getSurname(),
                $user->getConfirmationToken(),
                $user->getEmail())
            ;

            $this->swift->send($message);

            return true;
        }

        return false;
    }
}

