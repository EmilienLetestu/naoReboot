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
use App\Handler\AskResetHandler;
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
     * @var SessionInterface
     */
    private $session;

    /**
     * @var AskResetHandler
     */
    private $askResetHandler;


    /**
     * ResetPswdMailAction constructor.
     * @param FormFactoryInterface $formFactory
     * @param EntityManagerInterface $doctrine
     * @param SessionInterface $session
     * @param AskResetHandler $askResetHandler
     */
    public function __construct(
        FormFactoryInterface   $formFactory,
        EntityManagerInterface $doctrine,
        SessionInterface       $session,
        AskResetHandler        $askResetHandler

    )
    {
        $this->formFactory     = $formFactory;
        $this->doctrine        = $doctrine;
        $this->session         = $session;
        $this->askResetHandler = $askResetHandler;
    }


    /**
     * @param Request $request
     * @param ResetPswdMailResponder $responder
     * @return RedirectResponse|\Symfony\Component\HttpFoundation\Response
     */
    public function __invoke(Request $request, ResetPswdMailResponder $responder)
    {
        //generate needed object and form
        $user = new User();
        $form = $this->formFactory
                     ->create(AskResetType::class, $user)
                     ->handleRequest($request)
        ;

        if($this->askResetHandler->handle($form, $user))
        {

            $this->session->getFlashBag()
                ->add('success',
                    'Un email de changement de mot de passe vous a été envoyé !'
                )
            ;

            return new RedirectResponse('/accueil');
        }

        return $responder($form->createView());
    }
}