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
    private $token;
    private $updatePswd;

    /**
     * ProfileBuilder constructor.
     * @param EntityManager $doctrine
     * @param TokenStorage $token
     * @param UpdatePswd $updatePswd
     */
    public function __construct(
        EntityManager $doctrine,
        TokenStorage  $token,
        UpdatePswd    $updatePswd
    )
    {
        $this->doctrine   = $doctrine;
        $this->token      = $token;
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

        //create array with account creation date, chg pswd process and account type
        $accountInfo = [
            $user->getCreatedOn()->format('d-m-Y'),
            $this->updatePswd->changePswd($request),
            $user->getAccessLevel()
        ];

        //fetch all user reports
        $reportList =$user->getReports();

        return [
            $accountInfo,
            $this->getLastPublicationData($id),
            $reportList,
            $this->getActivitiesData($reportList)
        ];
    }

    public function buildPublicProfile($id)
    {
        //fetch profile info from db
        $user = $this->doctrine->getRepository(User::class)
            ->findOneBy(['id'=>$id]);

        //create array with collected data
        $accountInfo = [
            $user->getCreatedOn(),
            $user->getAccessLevel()
        ];

        //list all reports
        $reportList = $user->getReports();

        return [
            $accountInfo,
            $this->getLastPublicationData($id),
            $reportList,
            $this->getActivitiesData($reportList)
        ];
    }

    /**
     * fetch last publication and extract needed data
     * @param $id
     * @return array
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


