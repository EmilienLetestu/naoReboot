<?php
/**
 * Created by PhpStorm.
 * User: Emilien
 * Date: 06/02/2018
 * Time: 10:40
 */

namespace App\Action\Admin;


use App\Entity\User;
use App\Responder\Admin\AdminHomeResponder;
use App\Services\HomeImg;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;

class AdminHomeAction
{
    private $doctrine;

    private $homeImg;

    public function __construct(
        EntityManagerInterface $doctrine,
        HomeImg                $homeImg
    )
    {
        $this->doctrine = $doctrine;
        $this->homeImg = $homeImg;
    }

    /**
     * @param Request $request
     * @param AdminHomeResponder $responder
     * @return RedirectResponse|\Symfony\Component\HttpFoundation\Response
     */
    public function __invoke(Request $request, AdminHomeResponder $responder)
    {
        $repository = $this->doctrine->getRepository(User::class);
        $form = $this->homeImg->addPictureToHomePage($request);

        if($form === 'admin'){
            return new RedirectResponse('/admin');
        }


        return $responder(
            count($repository->countAllWithAccessLevel(1)),
            count($repository->countAllWithAccessLevel(2)),
            $this->homeImg->getHomeImage(),
            $form,
            'Espace d\'administration'
        );
    }

}