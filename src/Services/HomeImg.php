<?php
/**
 * Created by PhpStorm.
 * User: Emilien
 * Date: 07/11/2017
 * Time: 17:26
 */

namespace App\Services;

use App\Form\UpdateHomeType;

use Symfony\Component\Form\FormFactory;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Session\Session;

class HomeImg
{
    private $formFactory;
    private $tools;
    private $session;

    /**
     * Admin constructor.
     * @param FormFactory $formFactory
     * @param Tools $tools
     * @param Session $session
     */
    public function __construct(
        FormFactory   $formFactory,
        Tools         $tools,
        Session       $session
    )
    {
        $this->formFactory  = $formFactory;
        $this->tools        = $tools;
        $this->session      = $session;
    }

    /**
     * @param Request $request
     * @return string|\Symfony\Component\Form\FormView
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
                $pictureData.'.'.$file->guessExtension()
            );

            $this->session->getFlashBag()
                ->add('success','Mise à jour effectuée');

            return 'admin';
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

