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

    public function buildAdminHome(Request $request)
    {
        //get user list
        $repository = $this->doctrine->getRepository(User::class);

        //homepage img modification
        Return [
            count($repository->countAllWithAccessLevel(1)),
            count($repository->countAllWithAccessLevel(2)),
            $this->getHomeImage(),
            $this->addPictureToHomePage($request)
        ];
    }

    /**
     * @param Request $request
     * @return \Symfony\Component\Form\FormView
     */
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
                str_replace(' ','_',$birdSpecies),
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
     * @return array
     */
    public function getHomeImage()
    {
        $dir = '../public/naoPictures';

        $dirContent = scandir($dir);

        //remove '.' and '..' from array and return file name
        return  array_splice($dirContent,2);
    }


    /**
     * find image inside directory based on picture position from 1 to 3 (inside html)
     * return an array with up to 2 keys
     * => picture array key = picture position - 1
     * @param $pictNum
     * @return bool
     */
    public function deletePreviousHomeImage($pictNum)
    {
       //get pictures from directory
       $pictureContent = $this->getHomeImage();

       return unlink("../public/naoPictures/{$pictureContent[$pictNum-1]}");
    }

}

