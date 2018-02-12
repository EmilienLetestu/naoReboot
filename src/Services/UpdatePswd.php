<?php
/**
 * Created by PhpStorm.
 * User: emilien
 * Date: 27/09/17
 * Time: 09:44
 */

namespace App\Services;


use App\Entity\User;
use App\Form\Type\AskResetType;
use App\Form\Type\ChangePswdType;
use App\Form\Type\ResetPswdType;
use Doctrine\ORM\EntityManager;
use Symfony\Component\Form\FormFactory;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\HttpFoundation\Session\Session;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorage;

class UpdatePswd
{
    private $formFactory;
    private $doctrine;
    private $mailService;
    private $tools;
    private $swift;
    private $session;
    private $token;

    /**
     * UpdatePswd constructor.
     * @param FormFactory $formFactory
     * @param EntityManager $doctrine
     * @param Mails $mailService
     * @param Tools $tools
     * @param \Swift_Mailer $swift
     * @param Session $session
     * @param TokenStorage $token
     */
    public function __construct(
        FormFactory   $formFactory,
        EntityManager $doctrine,
        Mails         $mailService,
        Tools         $tools,
        \Swift_Mailer $swift,
        Session       $session,
        TokenStorage  $token
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
            //check if mail exist
            $user=$this->mailService->checkMailAvailability($user->getEmail());

            if(!$user)
            {
                $this->session->getFlashBag()
                    ->add('denied',
                        'Adresse e-mail inconnue'
                    )
                ;
               return $askResetForm->createView();
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
            return 'home';
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

            return 'home';
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

            //msg flash
            $this->session->getFlashBag()
                ->add('success',
                    'Le mot de passe  été modifier')
            ;

            return 'home';
        }

        return $resetForm->createView();
    }


    /**
     * modify password from profile page
     * @param Request $request
     * @return \Symfony\Component\Form\FormView
     */
    public function changePswd(Request $request)
    {
        //generate needed object and form
        $user = new User();
        $changeForm = $this->formFactory->create(ChangePswdType::class, $user);
        $changeForm->handleRequest($request);

        //process form
        if ($changeForm->isSubmitted() && $changeForm->isValid())
        {

            $user = $this->token->getToken()->getUser();
            $pswd = $user->getPswd();
            $currentPswd = $changeForm->get('currentPswd')->getData();

            if (!password_verify($currentPswd, $pswd))
            {
                $this->session->getFlashBag()
                    ->add('denied',
                        'Le mot de passe actuel ne correspond pas')
                ;

                return $changeForm->createView();
            }
            //get id
            $id = $user->getId();
            //hydrate with submitted data
            $user->setPswd($changeForm->get('pswd')->getData());
            //connection to db and update user pswd
            $user = $this->doctrine->getRepository(User::class)
            ->find($id);
            $this->doctrine->persist($user);
            $this->doctrine->flush();

            //msg flash
            $this->session->getFlashBag()
                ->add('success',
                    'Le mot de passe  été modifier')
            ;
        }

        return $changeForm->createView();
    }
}
