<?php
/**
 * Created by PhpStorm.
 * User: Emilien
 * Date: 07/02/2018
 * Time: 14:06
 */

namespace App\Handler;


use App\Entity\User;
use App\Handler\Inter\AskResetHandlerInterface;
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
        SessionInterface $session
    )
    {
        $this->mailService = $mailService;
        $this->session     = $session;
    }

    /**
     * @param FormInterface $form
     * @param User $user
     * @return bool|\Swift_Message
     */
    public function handle(FormInterface $form, User $user)
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
            $this->session->getFlashBag()
                ->add('success',
                    'Un email de changement de mot de passe vous a été envoyé !'
                )
            ;

            return $message;
        }

        return false;
    }
}
