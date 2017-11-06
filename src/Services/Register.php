<?php
/**
 * Created by PhpStorm.
 * User: emilien
 * Date: 26/09/17
 * Time: 14:47
 */

namespace App\Services;

use App\Entity\User;
use App\Form\RegisterType;

use Doctrine\ORM\EntityManager;
use Symfony\Component\Form\FormFactory;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\HttpFoundation\Session\Session;


class Register
{
    private $formFactory;
    private $requestStack;
    private $doctrine;
    private $swift;
    private $mailService;
    private $tools;
    private $session;

    /**
     * Register constructor.
     * @param FormFactory $formFactory
     * @param RequestStack $requestStack
     * @param EntityManager $doctrine
     * @param \Swift_Mailer $swift
     * @param Mails $mailService
     * @param Tools $tools
     * @param Session $session
     */
    public  function __construct(
        FormFactory         $formFactory,
        RequestStack        $requestStack,
        EntityManager       $doctrine,
        \Swift_Mailer       $swift,
        Mails               $mailService,
        Tools               $tools,
        Session             $session


    )
    {
        $this->formFactory  = $formFactory;
        $this->requestStack = $requestStack;
        $this->doctrine     = $doctrine;
        $this->swift        = $swift;
        $this->mailService  = $mailService;
        $this->tools        = $tools;
        $this->session      = $session;
    }


    /**
     * @param Request $request
     * @return array|string
     */
    public function registerUser(Request $request)
    {
        $user = new User();
        $registerForm = $this->formFactory->create(RegisterType::class, $user);
        $date = date('Y-m-d');

        $registerForm->handleRequest($request);
        if($registerForm->isSubmitted() && $registerForm->isValid())
        {
            //hydrate with submitted data
            $user
                ->setCreatedOn('Y-m-d');

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
                return $registerForm->createView();
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

            //save
            $this->doctrine->persist($user);
            $this->doctrine->flush();

            //send validation email
            $this->swift->send($message);

            $this->session->getFlashBag()
                ->add('success',
                    'Compte créé avec succès ! Un email d\'activation à été envoyé.'
                )
            ;

            return $redirect = 'home';
        }

        return $registerForm->createView();
    }
}