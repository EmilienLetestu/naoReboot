<?php
/**
 * Created by PhpStorm.
 * User: Emilien
 * Date: 05/02/2018
 * Time: 10:24
 */

namespace App\Action;


use App\Entity\User;
use App\Form\Type\RegisterType;
use App\Handler\RegisterHandler;
use App\Responder\LandingResponder;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Form\FormFactoryInterface;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;

class LandingAction
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
     * @var RegisterHandler
     */
    private $registerHandler;

    /**
     * @var UrlGeneratorInterface
     */
    private $urlGenerator;

    /**
     * LandingAction constructor.
     * @param FormFactoryInterface $formFactory
     * @param EntityManagerInterface $doctrine
     * @param RegisterHandler $registerHandler
     * @param UrlGeneratorInterface $urlGenerator
     */
    public function __construct(
        FormFactoryInterface   $formFactory,
        EntityManagerInterface $doctrine,
        RegisterHandler        $registerHandler,
        UrlGeneratorInterface  $urlGenerator
    )
    {
        $this->formFactory     = $formFactory;
        $this->doctrine        = $doctrine;
        $this->registerHandler = $registerHandler;
        $this->urlGenerator    = $urlGenerator;
    }

    /**
     * @param Request $request
     * @param LandingResponder $responder
     * @return RedirectResponse|\Symfony\Component\HttpFoundation\Response
     */
    public function __invoke(Request $request, LandingResponder $responder)
    {
        $user = new User();
        $form = $this->formFactory
                     ->create(RegisterType::class, $user)
                     ->handleRequest($request)
        ;


        if($this->registerHandler->handle($form, $user))
        {
            //save
            $this->doctrine->persist($user);
            $this->doctrine->flush();

            return new RedirectResponse(
                $this->urlGenerator->generate('home')
            );
        }

        return $responder($form->createView());
    }
}

