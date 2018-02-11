<?php
/**
 * Created by PhpStorm.
 * User: Emilien
 * Date: 05/02/2018
 * Time: 14:55
 */

namespace App\Action\Security;


use App\Entity\User;
use App\Form\RegisterType;
use App\Handler\RegisterHandler;
use App\Responder\Security\RegisterResponder;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Form\FormFactoryInterface;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;

class RegisterAction
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

    private $urlGenerator;

    /**
     * RegisterAction constructor.
     * @param FormFactoryInterface $formFactory
     * @param EntityManagerInterface $doctrine
     * @param RegisterHandler $registerHandler
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
     * @param RegisterResponder $responder
     * @return string|\Symfony\Component\HttpFoundation\Response
     */
    public function __invoke(Request $request, RegisterResponder $responder)
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