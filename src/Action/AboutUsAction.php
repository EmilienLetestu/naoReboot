<?php
/**
 * Created by PhpStorm.
 * User: Emilien
 * Date: 06/02/2018
 * Time: 09:51
 */

namespace App\Action;

use App\Form\ContactForm;

use App\Handler\ContactHandler;
use App\Responder\AboutUsResponder;
use App\Services\Mails;
use Symfony\Component\Form\FormFactoryInterface;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;

class AboutUsAction
{
    /**
     * @var FormFactoryInterface
     */
    private $formFactory;

    /**
     * @var ContactHandler
     */
    private $contactHandler;

    /**
     * @var SessionInterface
     */
    private $session;

    /**
     * @var UrlGeneratorInterface
     */
    private $urlGenerator;

    /**
     * AboutUsAction constructor.
     * @param FormFactoryInterface $formFactory
     * @param ContactHandler $contactHandler
     * @param SessionInterface $session
     * @param UrlGeneratorInterface $urlGenerator
     */
    public function  __construct(
        FormFactoryInterface  $formFactory,
        ContactHandler        $contactHandler,
        SessionInterface      $session,
        UrlGeneratorInterface $urlGenerator
    )
    {
        $this->formFactory    = $formFactory;
        $this->contactHandler = $contactHandler;
        $this->session        = $session;
        $this->urlGenerator   = $urlGenerator;
    }

    /**
     * @param Request $request
     * @param AboutUsResponder $responder
     * @return string|\Symfony\Component\HttpFoundation\Response
     */
    public function __invoke(Request $request, AboutUsResponder $responder)
    {
        $form = $this->formFactory
                     ->create(ContactForm::class)
                     ->handleRequest($request)
        ;

        if($this->contactHandler->handle($form))
        {
            $this->session->getFlashBag()
                ->add('success',
                    'Message envoyé, nous vous répondrons au plus vite'
                )
            ;

            return  new RedirectResponse(
                $this->urlGenerator->generate('home')
            );
        }

        return $responder(
            $form->createView()
        );
    }
}

