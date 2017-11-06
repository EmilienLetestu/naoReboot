<?php
/**
 * Created by PhpStorm.
 * User: emilien
 * Date: 26/09/17
 * Time: 16:05
 */

namespace App\Services;

use App\Entity\User;

use Doctrine\ORM\EntityManager;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Session\Session;

class ActivateAccount
{

    private $doctrine;
    private $session;
    private $mailService;
    private $tools;
    private $swift;


    /**
     * ActivateAccount constructor.
     * @param EntityManager $doctrine
     * @param Session $session
     * @param Mails $mailService
     * @param Tools $tools
     * @param \Swift_Mailer $swift
     */
    public  function __construct(
        EntityManager $doctrine,
        Session       $session,
        Mails         $mailService,
        Tools         $tools,
        \Swift_Mailer $swift

    )
    {
        $this->doctrine    = $doctrine;
        $this->session     = $session;
        $this->mailService = $mailService;
        $this->tools       = $tools;
        $this->swift       = $swift;

    }


    /**
     * @param Request $request
     * @return mixed
     */
    public function activateUserAccount(Request $request)
    {

        $email = $request->attributes->get('email');
        $token = $request->attributes->get('token');
        $date  = $request->attributes->get('expireOn');


        $repository = $this->doctrine->getRepository(User::class);
        $user       = $repository->findOneBy([
            'email'              => $email,
            'confirmationToken'  => $token
        ]);


        $stillValid = $this->tools->isLinkStillValid($date);

        if($stillValid === false)
        {
            //renvoyer un mail d'activation

            $message = $this->mailService->validationMail(
                $user->getName(),
                $user->getSurname(),
                $user->getConfirmationToken(),
                $user->getEmail()
            );

            $this->swift->send($message);

            return $this->session->getFlashBag()
                ->add('denied','L\'email a expiré, un nouvel email à été envoyé.')
                ;
        }

        if(!$user)
        {
            return $this->session->getFlashBag()
                ->add('error','Utilisateur inconnu')
                ;
        }

        $user->setActivated(true);
        $this->doctrine->flush();

        return $this->session->getFlashBag()
            ->add('success','Votre compte est activé !')
            ;
    }
}