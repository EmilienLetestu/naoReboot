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
    private $requestStack;
    private $formFactory;
    private $tools;
    private $file;
    private $session;

    public function __construct(
        EntityManager $doctrine,
        RequestStack  $requestStack,
        FormFactory   $formFactory,
        Tools         $tools,
        Filesystem    $file,
        Session       $session
    )
    {
        $this->doctrine     = $doctrine;
        $this->requestStack = $requestStack;
        $this->formFactory  = $formFactory;
        $this->tools        = $tools;
        $this->file         = $file;
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

            //remove file with same prefix

            $file->move(
                $uploadRootDir = '../public/naoPictures',
                $filename      = "{$pictureData['fileName']}.{$file->guessExtension()}"
            );

            $this->session->getFlashBag()
                ->add('success','Mise à jour effectuée');
        }

        return $updateForm->createView();
    }

}