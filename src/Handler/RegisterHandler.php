<?php

/**
 * Created by PhpStorm.
 * User: Emilien
 * Date: 06/02/2018
 * Time: 22:01
 */

namespace App\Handler;

use App\Entity\User;
use App\Handler\Interfaces\RegisterHandlerInterface;
use App\Services\Mails;
use App\Services\Tools;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\HttpFoundation\Session\SessionInterface;

class RegisterHandler implements RegisterHandlerInterface
{
    private $mailService;
    private $tools;
    private $session;

    public function __construct(
        Mails                  $mailService,
        Tools                  $tools,
        SessionInterface       $session
    )
    {
        $this->mailService = $mailService;
        $this->tools       = $tools;
        $this->session     = $session;
    }

    public function handle(FormInterface $form, User $user)
    {
        if($form->isSubmitted() && $form->isValid())
        {
            $user->setCreatedOn('Y-m-d');

            $emailInDb = $this->mailService
                ->checkMailAvailability($user->getEmail())
            ;

            if ($emailInDb !== null)
            {
                $this->session->getFlashBag()
                    ->add('denied',
                        'Cette email est déjà utilisé'
                    )
                ;
                return false;
            }

            //check if user requested an access level 1 or 2
            $status = $this->tools->getUserAccountStatus($user->getAccessLevel());

            //hydrate with default value
            $user
                ->setOnHold($status)
                ->setConfirmationToken(40);

            //prepare email
            $message = $this->mailService->validationMail(
                $user->getName(),
                $user->getSurname(),
                $user->getConfirmationToken(),
                $user->getEmail()
            );

            $this->session->getFlashBag()
                ->add('success',
                    'Compte créé avec succès ! Un email d\'activation à été envoyé.'
                )
            ;

            return $message;
        }

        return false;
    }
}
