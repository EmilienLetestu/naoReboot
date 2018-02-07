<?php
/**
 * Created by PhpStorm.
 * User: Emilien
 * Date: 07/02/2018
 * Time: 14:40
 */

namespace App\Handler;


use App\Handler\Inter\UpdateHomeHandlerInterface;
use App\Services\HomeImg;
use App\Services\Tools;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\HttpFoundation\Session\SessionInterface;

class UpdateHomeHandler implements UpdateHomeHandlerInterface
{
    /**
     * @var Tools
     */
    private $tools;

    /**
     * @var SessionInterface
     */
    private $session;

    /**
     * @var HomeImg
     */
    private $homeImg;

    /**
     * UpdateHomeHandler constructor.
     * @param Tools $tools
     * @param SessionInterface $session
     * @param HomeImg $homeImg
     */
    public function __construct(
        Tools            $tools,
        SessionInterface $session,
        HomeImg          $homeImg
    )
    {
        $this->tools = $tools;
        $this->session = $session;
        $this->homeImg = $homeImg;
    }

    /**
     * @param FormInterface $form
     * @return bool
     */
    public function handle(FormInterface $form): bool
    {
        if($form->isSubmitted() && $form->isValid())
        {
            //process data
            $birdSpecies  = $form->get('species')->getData();
            $pictToUpdate = $form->get('pictNum')->getData();

            $file         = $form->get('picture')->getData();
            $pictureData  = $this->tools->generateDataForHomeImg(
                str_replace(' ','_',$birdSpecies),
                $pictToUpdate
            );

            //remove file to update
            $this->homeImg
                 ->deletePreviousHomeImage($pictToUpdate)
            ;

            $file->move(
                '../public/naoPictures',
                $pictureData.'.'.$file->guessExtension()
            );

            $this->session->getFlashBag()
                ->add('success','Mise à jour effectuée');

            return true;
        }

        return false;
    }
}
