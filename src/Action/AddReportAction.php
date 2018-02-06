<?php
/**
 * Created by PhpStorm.
 * User: Emilien
 * Date: 05/02/2018
 * Time: 16:40
 */

namespace App\Action;

use App\Entity\Report;
use App\Form\ReportType;
use App\Responder\AddReportResponder;
use App\Services\Tools;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Form\FormFactoryInterface;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;

class AddReportAction
{
    private $formFactory;
    private $doctrine;
    private $session;
    private $tools;
    private $token;

    /**
     * AddReportAction constructor.
     * @param FormFactoryInterface $formFactory
     * @param EntityManagerInterface $doctrine
     * @param SessionInterface $session
     * @param Tools $tools
     * @param TokenStorageInterface $token
     */
    public function __construct(
        FormFactoryInterface   $formFactory,
        EntityManagerInterface $doctrine,
        SessionInterface       $session,
        Tools                  $tools,
        TokenStorageInterface  $token

    )
    {
        $this->formFactory  = $formFactory;
        $this->doctrine     = $doctrine;
        $this->session      = $session;
        $this->tools        = $tools;
        $this->token        = $token;
    }

    public function __invoke(Request $request, AddReportResponder $responder)
    {
        //generate form and required object
        $report = new Report();
        $reportForm = $this->formFactory->create(ReportType::class, $report);

        $reportForm->handleRequest($request);

        //process form
        if($reportForm->isSubmitted() && $reportForm->isValid())
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
            if($reportForm->get('comment')->getData())
            {
                $report->setComment($reportForm->get('comment')->getData());
            }
            //----process pict----//
            //--1 generate filename
            $birdSpecies = serialize($reportForm->get('bird')->getData());
            //--2 get submitted file
            $file = $reportForm->get('pictRef')->getData();

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

            //save
            $this->doctrine->getRepository(Report::class);
            $this->doctrine->persist($report);
            $this->doctrine->flush();

            $this->session->getFlashBag()->add('success','Votre observation a bien été ajoutée !');

            return new RedirectResponse('/observations/nouvelle-observation');
        }

        return $responder($reportForm->createView());
    }
}
