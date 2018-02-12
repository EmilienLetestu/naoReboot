<?php
/**
 * Created by PhpStorm.
 * User: Emilien
 * Date: 05/02/2018
 * Time: 16:14
 */

namespace App\Action;

use App\Entity\User;
use App\Form\Type\ResetPswdType;
use App\Handler\ResetPswdHandler;
use App\Responder\ResetPswdFormResponder;
use App\Services\Mails;
use App\Services\Tools;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Form\FormFactoryInterface;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;
class ResetPswdFormAction
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
     * @var ResetPswdHandler
     */
    private $resetPswdHandler;


    private $urlGenerator;

    /**
     * ResetPswdFormAction constructor.
     * @param FormFactoryInterface $formFactory
     * @param EntityManagerInterface $doctrine
     * @param Mails $mailService
     * @param Tools $tools
     * @param \Swift_Mailer $swift
     * @param SessionInterface $session
     * @param TokenStorageInterface $token
     * @param ResetPswdHandler $resetPswdHandler
     */
    public function __construct(
        FormFactoryInterface   $formFactory,
        EntityManagerInterface $doctrine,
        Mails                  $mailService,
        Tools                  $tools,
        \Swift_Mailer          $swift,
        SessionInterface       $session,
        TokenStorageInterface  $token,
        ResetPswdHandler       $resetPswdHandler,
        UrlGeneratorInterface  $urlGenerator
    )
    {
        $this->formFactory      = $formFactory;
        $this->doctrine         = $doctrine;
        $this->mailService      = $mailService;
        $this->tools            = $tools;
        $this->swift            = $swift;
        $this->session          = $session;
        $this->token            = $token;
        $this->resetPswdHandler = $resetPswdHandler;
        $this->urlGenerator     = $urlGenerator;
    }

    public function __invoke(Request $request, ResetPswdFormResponder $responder)
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

            return new RedirectResponse(
                $this->urlGenerator->generate('home')
            );
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

            return new RedirectResponse(
                $this->urlGenerator->generate('home')
            );
        }

        //generate needed object and form
        $form = $this->formFactory
                     ->create(ResetPswdType::class, $user)
                     ->handleRequest($request)
        ;

        if($this->resetPswdHandler->handle($form, $user))
        {
            $this->doctrine->persist($user);
            $this->doctrine->flush();

            $this->session->getFlashBag()
                ->add('success', 'Le mot de passe  été modifier')
            ;

            return new RedirectResponse(
                $this->urlGenerator->generate('home')
            );
        }

        return $responder($form->createView());
    }
}