<?php
/**
 * Created by PhpStorm.
 * User: Emilien
 * Date: 24/03/2018
 * Time: 12:04
 */

namespace App\Action;

use App\Entity\User;
use App\Responder\ActivationMailResponder;
use App\Services\Mails;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Session\SessionInterface;

class ActivationMailAction
{
    /**
     * @var EntityManagerInterface
     */
    private $doctrine;

    /**
     * @var Mails
     */
    private $mails;

    /**
     * @var \Swift_Mailer
     */
    private $swift;

    /**
     * @var SessionInterface
     */
    private $session;


    /**
     * ActivationMailAction constructor.
     * @param EntityManagerInterface $doctrine
     * @param Mails $mails
     * @param \Swift_Mailer $swift
     * @param SessionInterface $session
     */
    public function __construct(
        EntityManagerInterface $doctrine,
        Mails                  $mails,
        \Swift_Mailer          $swift,
        SessionInterface       $session
    )
    {
        $this->doctrine     = $doctrine;
        $this->mails        = $mails;
        $this->swift        = $swift;
        $this->session      = $session;
    }

    /**
     * @param Request $request
     * @param ActivationMailResponder $responder
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     */
    public function __invoke(Request $request, ActivationMailResponder $responder)
    {
        $user = $this->doctrine->getRepository(User::class)
            ->findLogin($request->attributes->get('email'))
        ;

        if(!$user){
            $this->session->getFlashBag()
                ->add('denied','Nous n\'avons pas pu générer de nouvel e-mail.')
            ;

            return $responder();
        }

        $this->swift
            ->send($this->mails
            ->validationMail(
                $user[0]->getName(),
                $user[0]->getSurname(),
                $user[0]->getConfirmationToken(),
                $user[0]->getEmail()
            )
        );

        $this->session->getFlashBag()
            ->add('success','Un nouvel email d\'activation à été envoyé!')
        ;

       return $responder();
    }
}
