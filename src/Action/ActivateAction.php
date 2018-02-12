<?php
/**
 * Created by PhpStorm.
 * User: Emilien
 * Date: 05/02/2018
 * Time: 15:19
 */

namespace App\Action;


use App\Entity\User;
use App\Responder\ActivateResponder;
use App\Services\Mails;
use App\Services\Tools;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Session\SessionInterface;

class ActivateAction
{
    /**
     * @var EntityManagerInterface
     */
    private $doctrine;

    /**
     * @var SessionInterface
     */
    private $session;

    /**
     * @var Mails
     */
    private $mailService;

    /**
     * @var Tools
     */
    private $tools;

    /**
     * @var \Swift_Mailer
     */
    private $swift;

    /**
     * ActivateAction constructor.
     * @param EntityManagerInterface $doctrine
     * @param SessionInterface $session
     * @param Mails $mailService
     * @param Tools $tools
     * @param \Swift_Mailer $swift
     */
    public  function __construct(
        EntityManagerInterface $doctrine,
        SessionInterface       $session,
        Mails                  $mailService,
        Tools                  $tools,
        \Swift_Mailer          $swift

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
     * @param ActivateResponder $responder
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     */
    public function __invoke(Request $request, ActivateResponder $responder)
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

            $this->session->getFlashBag()
                 ->add('denied','L\'email a expiré, un nouvel email à été envoyé.')
            ;

            return $responder();
        }

        if(!$user)
        {
            $this->session->getFlashBag()
                 ->add('error','Utilisateur inconnu')
            ;

            return $responder();
        }

        $user->setActivated(true);
        $this->doctrine->flush();

        $this->session->getFlashBag()
             ->add('success','Votre compte est activé !')
        ;

        return $responder();
    }

}
