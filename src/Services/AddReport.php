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


class AddReport
{
    private $formFactory;
    private $requestStack;
    private $doctrine;
    private $session;
    private $file;
    private $tools;

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
        Tools         $tools

    )
    {
        $this->formFactory  = $formFactory;
        $this->requestStack = $requestStack;
        $this->doctrine     = $doctrine;
        $this->session      = $session;
        $this->file         = $file;
        $this->tools        = $tools;
    }


    public function addReportProcess(Request $request)
    {
        //generate form and required object
        $report = new Report();
        $reportForm = $this->formFactory->create(ReportType::class, $report);
        //get user data from session
        //$user = $this->session->get('user');

        $reportForm->handleRequest($request);

        //process form
        if($reportForm->isSubmitted() && $reportForm->isValid())
        {
            //get report default data
            //$default = $this->reportGateways(
            //    $this->session->get('user')->getId()
            //);

            // !! -- temporary will use session as soon as session bug will be fixed -- !! //
            $rep = $this->doctrine->getRepository(User::class);
            $user = $rep->find(1);
            $report
                ->setValidated(false)
                ->setValidationScore(0)
                ->setUser($user)
                ->setStarNbr(0)
                ->setNbrOfBirds($reportForm->get('nbrOfBirds')->getData())
                ->setAddedOn($reportForm->get('addedOn')->getData())
                ->setComment($reportForm->get('comment')->getData())
                // !! -- temporary will use googleMap Api data later on -- !! //
                ->setSatNav($reportForm->get('googleMap')->getData())
                ->setLocation('sdsdqsd');

            //process pict and save into "userImages" directory
            $file = $reportForm->get('pictRef')->getData();
            //generate filename
            $pictName = $this->tools->generateDataForUserImg(
                $reportForm->get('bird')->getData(),
                $user->getId()
            );
            $file->move(
                $uploadRootDir = '../public/userImages',
                $filename = "$pictName.{$file->guessExtension()}"
            );
            $report->setPictRef($filename);

            //save
            $this->doctrine->getRepository(Report::class);
            $this->doctrine->persist($report);
            $this->doctrine->flush();

            $this->session->getFlashBag()->add('succes','Votre observation a bien été ajoutée !');

            return $reportForm->createView();
        }

        return $reportForm->createView();
    }

    /**
     * @param $accessLevel
     * @return array
     */
    public function reportGateways($accessLevel)
    {
        $gateWays = [
            $validated = $accessLevel > 1 ? true : false,
            $validationScore = $validated === true ? 5 : 0,
            $star = 0
        ]
        ;
        return $gateWays;
    }
}