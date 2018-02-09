<?php
/**
 * Created by PhpStorm.
 * User: Emilien
 * Date: 07/02/2018
 * Time: 08:18
 */

namespace App\Handler;


use App\Entity\Report;
use App\Handler\Interfaces\ReportHandlerInterface;
use App\Services\Tools;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;

class ReportHandler implements ReportHandlerInterface
{
    /**
     * @var TokenStorageInterface
     */
    private $token;

    /**
     * @var Tools
     */
    private $tools;

    /**
     * @var SessionInterface
     */
    private $session;

    /**
     * ReportHandler constructor.
     * @param TokenStorageInterface $token
     * @param Tools $tools
     * @param SessionInterface $session
     */
    public function __construct(
        TokenStorageInterface $token,
        Tools                 $tools,
        SessionInterface      $session
    )
    {
        $this->token   = $token;
        $this->tools   = $tools;
        $this->session = $session;
    }


    /**
     * @param FormInterface $form
     * @param Report $report
     * @return bool
     */
    public function handle(FormInterface $form, Report $report): bool
    {
        if($form->isSubmitted() && $form->isValid())
        {
            //get user level and object
            $level   = $this->token->getToken()->getUser()->getAccessLevel();
            $onHold  = $this->token->getToken()->getUser()->getOnHold();
            $user    = $this->token->getToken()->getUser();

            //prepare report default data
            $default = $this->tools->reportGateways($level,$onHold);

            //hydrate report object
            $report
                ->setValidated($default[0])
                ->setValidationScore($default[1])
                ->setStarNbr($default[2])
                ->setUser($user);
            if($form->get('comment')->getData())
            {
                $report->setComment($form->get('comment')->getData());
            }
            //----process pict----//
            //--1 generate filename
            $birdSpecies = serialize($form->get('bird')->getData());
            //--2 get submitted file
            $file = $form->get('pictRef')->getData();

            if($file !== null)
            {
                $pictName = $this->tools->generateDataForUserImg(
                    $birdSpecies,
                    $user->getId()
                );
                //--3 rename it and store it into userImages directory
                $file->move(
                    '../public/userImages',
                    $filename = "$pictName[0].{$file->guessExtension()}"
                );
                //--4 hydrate report with filename
                $report->setPictRef($filename);
            }

            $this->session->getFlashBag()->add('success','Votre observation a bien été ajoutée !');

            return true;
        }

        return false;
    }
}