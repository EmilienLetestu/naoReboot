<?php
/**
 * Created by PhpStorm.
 * User: emilien
 * Date: 27/09/17
 * Time: 09:44
 */

namespace App\Services;


use App\Entity\User;
use App\Form\AskResetType;
use App\Form\ResetPswdType;
use Doctrine\ORM\EntityManager;
use Symfony\Component\Form\FormFactory;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\HttpFoundation\Session\Session;

class ResetPswd
{
    private $formFactory;
    private $doctrine;
    private $requestStack;
    private $mailService;
    private $tools;
    private $swift;
    private $session;

    /**
     * ResetPswd constructor.
     * @param FormFactory $formFactory
     * @param EntityManager $doctrine
     * @param RequestStack $requestStack
     * @param Mails $mailService
     * @param Tools $tools
     * @param \Swift_Mailer $swift
     * @param Session $session
     */
    public function __construct(
        FormFactory   $formFactory,
        EntityManager $doctrine,
        RequestStack  $requestStack,
        Mails         $mailService,
        Tools         $tools,
        \Swift_Mailer $swift,
        Session       $session
    )
    {
        $this->formFactory  = $formFactory;
        $this->doctrine     = $doctrine;
        $this->requestStack = $requestStack;
        $this->mailService  = $mailService;
        $this->tools        = $tools;
        $this->swift        = $swift;
        $this->session      = $session;
    }

    /**
     * @param Request $request
     * @return \Symfony\Component\Form\FormView
     */
    public function askReset(Request $request)
    {
        //generate needed object and form
        $user = new User();
        $askResetForm = $this->formFactory->create(AskResetType::class, $user);
        $askResetForm->handleRequest($request);

        //process form
        if($askResetForm->isSubmitted() && $askResetForm->isValid())
        {
            //hydrate user with submitted data
            $user->setEmail($askResetForm->get('email')->getData());

            //check if mail exist
            $user=$this->mailService->checkMailAvailability($user->getEmail());

            if(!$user)
            {
                $this->session->getFlashBag()
                    ->add('denied',
                          'Adresse e-mail inconnue'
                    )
                ;
            }
            //prepare email and send it
            $message = $this->mailService->resetPswdMail(
                $user->getName(),
                $user->getSurname(),
                $user->getConfirmationToken(),
                $user->getEmail())
            ;
            $this->swift->send($message);
        }

        return $askResetForm->createView();
    }

    /**
     * @param Request $request
     * @return string|\Symfony\Component\Form\FormView
     */
    public function resetPswd(Request $request)
    {
        //get url parameter
        $expireDate = $request->attributes->get('expireOn');
        $email      = $request->attributes->get('email');
        $token      = $request->attributes->get('token');

        //check if data from db match url
        $repository = $this->doctrine->getRepository(User::class);
        $user       = $repository->findOneBy([
            'email'              => $email,
            'confirmationToken'  => $token
        ]);

        if(!$user)
        {
            $this->session->getFlashBag()
                ->add('denied',
                    'Adresse e-mail inconnue'
                )
            ;
            return $redirect = 'home';
        }

        //check if mail still valid
        $stillValid = $this->tools->isLinkStillValid($expireDate);

        if($stillValid === false)
        {
            $this->session->getFlashBag()
                ->add('denied',
                    'Votre lien a expiré, un nouvel email vous à été envoyé'
                )
            ;
            //prepare email and send it
            $message = $this->mailService->resetPswdMail(
                $user->getName(),
                $user->getSurname(),
                $user->getConfirmationToken(),
                $user->getEmail())
            ;
            $this->swift->send($message);

            return $redirect = 'home';
        }

        //generate needed object and form
        $resetForm = $this->formFactory->create(ResetPswdType::class, $user);
        $resetForm->handleRequest($request);

        //process form data
        if($resetForm->isSubmitted() && $resetForm->isValid())
        {
            //hydrate user object with new password
            $user->setPswd($resetForm->get('pswd')->getData());
            //store into db
            $this->doctrine->flush();

            return $redirect = 'home';
        }

        return $resetForm->createView();
    }


}