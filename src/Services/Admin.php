<?php
/**
 * Created by PhpStorm.
 * User: emil
 * Date: 05/10/17
 * Time: 12:50
 */

namespace App\Services;


use App\Entity\Report;
use App\Entity\User;
use App\Form\UpdateHomeType;
use Doctrine\ORM\EntityManager;

use Symfony\Component\Filesystem\Filesystem;
use Symfony\Component\Form\FormFactory;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\HttpFoundation\Session\Session;


class Admin
{
    private $doctrine;
    private $formFactory;
    private $tools;
    private $session;

    /**
     * Admin constructor.
     * @param EntityManager $doctrine
     * @param FormFactory $formFactory
     * @param Tools $tools
     * @param Session $session
     */
    public function __construct(
        EntityManager $doctrine,
        FormFactory   $formFactory,
        Tools         $tools,
        Session       $session
    )
    {
        $this->doctrine     = $doctrine;
        $this->formFactory  = $formFactory;
        $this->tools        = $tools;
        $this->session      = $session;
    }

    public function buildAdminHome()
    {
        //get user list
        $repository = $this->doctrine->getRepository(User::class);
        $userList   = $repository->findAll();

        foreach ($userList as $user)
        {
            $accessLevel[] = $user->getAccessLevel();
            $minLevel = array_search(1,$accessLevel);
            $maxLevel = array_search(2,$accessLevel);

        }

        //homepage img modification
        Return [
            count($userList),
            count($minLevel),
            count($maxLevel)
        ];
    }

    public function addPictureToHomePage(Request $request)
    {
        $updateForm = $this->formFactory->create(UpdateHomeType::class);

        $updateForm->handleRequest($request);
        if($updateForm->isSubmitted() && $updateForm->isValid())
        {
            //process data
            $birdSpecies  = $updateForm->get('species')->getData();
            $pictToUpdate = $updateForm->get('pictNum')->getData();
            $file         = $updateForm->get('picture')->getData();
            $pictureData  = $this->tools->generateDataForHomeImg(
                $birdSpecies,
                $pictToUpdate
            );

            //remove file to update
            $this->deletePreviousHomeImage($pictToUpdate);

            $file->move(
                '../public/naoPictures',
                "{$pictureData['fileName']}.{$file->guessExtension()}"
            );

            $this->session->getFlashBag()
                ->add('success','Mise à jour effectuée');
        }

        return $updateForm->createView();
    }


    /**
     * @param $pictNum
     * @return bool
     */
    public function deletePreviousHomeImage($pictNum)
    {
        $dir = '../public/naoPictures';
        $dirContent = scandir($dir);

        //add 2 to picture number to find its position in array
        $filePosition = $pictNum + 2;

       return unlink("../public/naoPictures/{$dirContent[$filePosition]}");
    }

}
