<?php
/**
 * Created by PhpStorm.
 * User: Emilien
 * Date: 06/02/2018
 * Time: 10:40
 */

namespace App\Action\Admin;


use App\Entity\User;
use App\Form\UpdateHomeType;
use App\Handler\UpdateHomeHandler;
use App\Responder\Admin\AdminHomeResponder;
use App\Services\HomeImg;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Form\FormFactoryInterface;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;

class AdminHomeAction
{
    /**
     * @var EntityManagerInterface
     */
    private $doctrine;

    /**
     * @var HomeImg
     */
    private $homeImg;

    /**
     * @var UpdateHomeHandler
     */
    private $updateHomeHandler;

    /**
     * @var FormFactoryInterface
     */
    private $formFactory;

    /**
     * AdminHomeAction constructor.
     * @param EntityManagerInterface $doctrine
     * @param HomeImg $homeImg
     * @param UpdateHomeHandler $updateHomeHandler
     * @param FormFactoryInterface $formFactory
     */
    public function __construct(
        EntityManagerInterface $doctrine,
        HomeImg                $homeImg,
        UpdateHomeHandler      $updateHomeHandler,
        FormFactoryInterface   $formFactory

    )
    {
        $this->doctrine          = $doctrine;
        $this->homeImg           = $homeImg;
        $this->updateHomeHandler = $updateHomeHandler;
        $this->formFactory       = $formFactory;
    }

    /**
     * @param Request $request
     * @param AdminHomeResponder $responder
     * @return RedirectResponse|\Symfony\Component\HttpFoundation\Response
     */
    public function __invoke(Request $request, AdminHomeResponder $responder)
    {
        $repository = $this->doctrine->getRepository(User::class);
        $form = $this->formFactory
                     ->create(UpdateHomeType::class)
                     ->handleRequest($request)
        ;

        if($this->updateHomeHandler->handle($form))
        {
            return new RedirectResponse('/admin');
        }

        return $responder(
            count($repository->countAllWithAccessLevel(1)),
            count($repository->countAllWithAccessLevel(2)),
            $this->homeImg->getHomeImage(),
            $form->createView(),
            'Espace d\'administration'
        );
    }

}