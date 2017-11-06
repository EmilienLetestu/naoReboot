<?php
/**
 * Created by PhpStorm.
 * User: emilien
 * Date: 27/09/17
 * Time: 15:22
 */

namespace App\Services;

use App\Entity\Report;
use App\Entity\User;
use App\Form\ReportType;
use Doctrine\ORM\EntityManager;
use Symfony\Component\Filesystem\Filesystem;
use Symfony\Component\Form\FormFactory;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\HttpFoundation\Session\Session;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorage;


class AddReport
{
    private $formFactory;
    private $requestStack;
    private $doctrine;
    private $session;
    private $file;
    private $tools;
    private $token;

    /**
     * AddReport constructor.
     * @param FormFactory $formFactory
     * @param RequestStack $requestStack
     * @param EntityManager $doctrine
     * @param Session $session
     * @param Filesystem $file
     * @param Tools $tools
     */
    public function __construct(
        FormFactory   $formFactory,
        RequestStack  $requestStack,
        EntityManager $doctrine,
        Session       $session,
        Filesystem    $file,
        Tools         $tools,
        TokenStorage  $token

    )
    {
        $this->formFactory  = $formFactory;
        $this->requestStack = $requestStack;
        $this->doctrine     = $doctrine;
        $this->session      = $session;
        $this->file         = $file;
        $this->tools        = $tools;
        $this->token        = $token;
    }


    public function addReportProcess(Request $request)
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
            $user    = $this->token->getToken()->getUser();

            //prepare report default data
            $default = $this->reportGateways($level);

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
                    $uploadRootDir = '../public/userImages',
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

            return $reportForm->createView();
        }

        return $reportForm->createView();
    }

    /**
     * set default report data based on user accessLevel
     * @param $accessLevel
     * @return array
     */
    public function reportGateways($accessLevel)
    {
        $gateWays = [
            $validated = $accessLevel > 1 ? true : false,
            $validationScore = $validated === true ? 5 : 0,
            $starNbr = 0
        ]
        ;
        return $gateWays;
    }
}