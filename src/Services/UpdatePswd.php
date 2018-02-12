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

