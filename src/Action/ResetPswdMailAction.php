<?php
/**
 * Created by PhpStorm.
 * User: Emilien
 * Date: 05/02/2018
 * Time: 15:54
 */

namespace App\Action;


use App\Entity\User;
use App\Form\Type\AskResetType;
use App\Handler\AskResetHandler;
use App\Responder\ResetPswdMailResponder;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Form\FormFactoryInterface;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;

class ResetPswdMailAction
{
    /**
     * @var FormFactoryInterface
     */
    private $formFactory;

    /**
     * @var SessionInterface
     */
    private $session;

    /**
     * @var AskResetHandler
     */
    private $askResetHandler;

    /**
     * @var UrlGeneratorInterface
     */
    private $urlGenerator;


    /**
     * ResetPswdMailAction constructor.
     * @param FormFactoryInterface $formFactory
     * @param SessionInterface $session
     * @param AskResetHandler $askResetHandler
     * @param UrlGeneratorInterface $urlGenerator
     */
    public function __construct(
        FormFactoryInterface   $formFactory,
        SessionInterface       $session,
        AskResetHandler        $askResetHandler,
        UrlGeneratorInterface  $urlGenerator

    )
    {
        $this->formFactory     = $formFactory;
        $this->session         = $session;
        $this->askResetHandler = $askResetHandler;
        $this->urlGenerator    = $urlGenerator;
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

            return new RedirectResponse(
                $this->urlGenerator->generate('home')
            );
        }

        return $responder($form->createView());
    }
}
