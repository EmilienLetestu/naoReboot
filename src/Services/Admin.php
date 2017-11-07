<?php
/**
 * Created by PhpStorm.
 * User: emil
 * Date: 05/10/17
 * Time: 12:50
 */

namespace App\Services;

use App\Entity\User;

use Doctrine\ORM\EntityManager;
use Symfony\Component\HttpFoundation\Request;

class Admin
{
    private $doctrine;
    private $homeImg;


    public function __construct(
        EntityManager $doctrine,
        HomeImg       $homeImg
    )
    {
        $this->doctrine = $doctrine;
        $this->homeImg  = $homeImg;
    }

    /**
     * @param Request $request
     * @return array
     */
    public function buildAdminHome(Request $request)
    {
        //get user list
        $repository = $this->doctrine->getRepository(User::class);

        //homepage img modification
        Return [
            count($repository->countAllWithAccessLevel(1)),
            count($repository->countAllWithAccessLevel(2)),
            $this->homeImg->getHomeImage(),
            $this->homeImg->addPictureToHomePage($request)
        ];
    }

}

