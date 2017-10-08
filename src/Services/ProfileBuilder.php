<?php
/**
 * Created by PhpStorm.
 * User: emil
 * Date: 03/10/17
 * Time: 23:01
 */

namespace App\Services;

use App\Entity\Report;
use App\Entity\User;
use Doctrine\ORM\EntityManager;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Session\Session;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorage;

class ProfileBuilder
{
    private $doctrine;
    private $session;
    private $token;
    private $tools;
    private $updatePswd;

    /**
     * ProfileBuilder constructor.
     * @param EntityManager $doctrine
     * @param Session $session
     * @param TokenStorage $token
     * @param Tools $tools
     * @param UpdatePswd $updatePswd
     */
    public function __construct(
        EntityManager $doctrine,
        Session       $session,
        TokenStorage  $token,
        Tools         $tools,
        UpdatePswd    $updatePswd
    )
    {
        $this->doctrine   = $doctrine;
        $this->session    = $session;
        $this->token      = $token;
        $this->tools      = $tools;
        $this->updatePswd = $updatePswd;
    }

    /**
     * @param Request $request
     * @return array
     */
    public function buildPrivateProfile(Request $request)
    {
        //fetch id and createdOn into tokenStorage
        $user        = $this->token->getToken()->getUser();
        $id          = $user->getId();
        $createdOn   = $user->getCreatedOn()->format('d-m-Y');
        $accessLevel = $user->getAccessLevel();

        //get account type
        $accountType = $this->tools->displayAccountType($accessLevel);

        //change pswd process
        $changePswd = $this->updatePswd->changePswd($request);

        //create array with collected data
        $accountInfo = [$createdOn, $changePswd ,$accountType];

        //fetch last published one
        $lastInfo = $this->getLastPublicationData($id);

        //fetch all user reports
        $reportList =$user->getReports();

        //extract data from report list
        $reportsInfo = $this->getActivitiesData($reportList);


        return [
            $accountInfo,
            $lastInfo,
            $reportsInfo,
            $reportList
        ];
    }

    public function buildPublicProfile($id)
    {
        //fetch profile info from db
        $user = $this->doctrine->getRepository(User::class)
            ->findOneBy(['id'=>$id]);

        //hydrate needed user property
        $createdOn = $user->getCreatedOn()->format('d-m-y');
        $accessLevel = $user->getAccessLevel();
        $accountType = $this->tools->displayAccountType($accessLevel);

        //create array with collected data
        $accountInfo = [$createdOn,$accountType];

        //fetch last published one
        $lastInfo = $this->getLastPublicationData($id);

        //list all reports
        $reportList = $user->getReports();

        //extract data from report list
        $reportsInfo = $this->getActivitiesData($reportList);

        return [
            $accountInfo,
            $lastInfo,
            $reportsInfo,
            $reportList
        ];
    }

    /**
     * fetch last publication and extract needed data
     * @param $id
     * @return array|string
     */
    public function getLastPublicationData($id)
    {
        //fetch last published one
        $lastReport = $this->doctrine->getRepository(Report::class)
            ->findUserLastPublication($id);

        if(!$lastReport)
        {
           return [
               $date   = '-------------',
               $bird   = '-------------',
               $satNav = '-------------'];
        }

        foreach ($lastReport as $report)
        {
            $date   = $report->getAddedOn()->format('d-m-y');
            $bird   = $report->getBird()->getSpeciesFr();
            $satNav = $report->getSatNav();
        }

        return  [
            $date,
            $bird,
            $satNav]
        ;
    }

    /**
     * extract general information from user publications
     * @param $reportList
     * @return array
     */
    public function getActivitiesData($reportList)
    {
        foreach ($reportList as $report)
        {
            $stars[] = $report->getStarNbr();
            $validations[] = $report->getValidated();
            $unvalidated[] = array_search(0,$validations);
            $validated[] = array_search(1,$validations);
        }

        return [
            count($unvalidated),
            count($validated),
            array_sum($stars)
        ];
    }
}

