<?php
/**
 * Created by PhpStorm.
 * User: Emilien
 * Date: 05/02/2018
 * Time: 10:24
 */

namespace App\Action;


use App\Entity\User;
use App\Form\RegisterType;
use App\Responder\LandingResponder;
use App\Services\Mails;
use App\Services\Tools;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Form\FormFactoryInterface;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Session\SessionInterface;

class LandingAction
{
    private $formFactory;
    private $doctrine;
    private $swift;
    private $mailService;
    private $tools;
    private $session;

    public function __construct(
        FormFactoryInterface   $formFactory,
        EntityManagerInterface $doctrine,
        \Swift_Mailer          $swift,
        Mails                  $mailService,
        Tools                  $tools,
        SessionInterface       $session
    )
    {
        $this->formFactory = $formFactory;
        $this->doctrine    = $doctrine;
        $this->swift       = $swift;
        $this->mailService = $mailService;
        $this->tools       = $tools;
        $this->session     = $session;
    }

    public function __invoke(Request $request, LandingResponder $responder)
    {
        $user = new User();
        $registerForm = $this->formFactory->create(RegisterType::class, $user);

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
                return $responder($registerForm->createView());
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

            return new RedirectResponse('/accueil');
        }

        return $responder($registerForm->createView());
    }
}
