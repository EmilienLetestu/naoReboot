<?php
/**
 * Created by PhpStorm.
 * User: Emilien
 * Date: 05/02/2018
 * Time: 15:54
 */

namespace App\Action;


use App\Entity\User;
use App\Form\AskResetType;
use App\Responder\ResetPswdMailResponder;
use App\Services\Mails;
use App\Services\Tools;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Form\FormFactoryInterface;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;

class ResetPswdMailAction
{
    /**
     * @var FormFactoryInterface
     */
    private $formFactory;

    /**
     * @var EntityManagerInterface
     */
    private $doctrine;

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
     * @var SessionInterface
     */
    private $session;

    /**
     * @var TokenStorageInterface
     */
    private $token;

    /**
     * ResetPswdAction constructor.
     * @param FormFactoryInterface $formFactory
     * @param EntityManagerInterface $doctrine
     * @param Mails $mailService
     * @param Tools $tools
     * @param \Swift_Mailer $swift
     * @param SessionInterface $session
     * @param TokenStorageInterface $token
     */
    public function __construct(
        FormFactoryInterface   $formFactory,
        EntityManagerInterface $doctrine,
        Mails                  $mailService,
        Tools                  $tools,
        \Swift_Mailer          $swift,
        SessionInterface       $session,
        TokenStorageInterface  $token
    )
    {
        $this->formFactory  = $formFactory;
        $this->doctrine     = $doctrine;
        $this->mailService  = $mailService;
        $this->tools        = $tools;
        $this->swift        = $swift;
        $this->session      = $session;
        $this->token        = $token;
    }

    public function __invoke(Request $request, ResetPswdMailResponder $responder)
    {
        //generate needed object and form
        $user = new User();
        $askResetForm = $this->formFactory->create(AskResetType::class, $user);
        $askResetForm->handleRequest($request);

        //process form
        if($askResetForm->isSubmitted() && $askResetForm->isValid())
        {
            //check if mail exist
            $user=$this->mailService->checkMailAvailability($user->getEmail());

            if(!$user)
            {
                $this->session->getFlashBag()
                    ->add('denied',
                        'Adresse e-mail inconnue'
                    )
                ;
                return $responder($askResetForm->createView());
            }
            //prepare email and send it
            $message = $this->mailService->resetPswdMail(
                $user->getName(),
                $user->getSurname(),
                $user->getConfirmationToken(),
                $user->getEmail())
            ;
            $this->swift->send($message);

            $this->session->getFlashBag()
                ->add('success',
                    'Un email de changement de mot de passe vous a été envoyé !'
                )
            ;

            return new RedirectResponse('/accueil');
        }

        return $responder($askResetForm->createView());
    }
}