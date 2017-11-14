<?php
/**
 * Created by PhpStorm.
 * User: emil
 * Date: 03/10/17
 * Time: 23:01
 */

namespace App\Builders;

use App\Entity\User;
use App\Services\ActivitiesTracker;
use App\Services\UpdatePswd;
use Doctrine\ORM\EntityManager;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorage;

class ProfileBuilder
{
    private $doctrine;
    private $token;
    private $updatePswd;
    private $activitiesTracker;

    /**
     * ProfileBuilder constructor.
     * @param EntityManager $doctrine
     * @param TokenStorage $token
     * @param UpdatePswd $updatePswd
     * @param ActivitiesTracker $activitiesTracker
     */
    public function __construct(
        EntityManager     $doctrine,
        TokenStorage      $token,
        UpdatePswd        $updatePswd,
        ActivitiesTracker $activitiesTracker

    )
    {
        $this->doctrine          = $doctrine;
        $this->token             = $token;
        $this->updatePswd        = $updatePswd;
        $this->activitiesTracker = $activitiesTracker;
    }

    /**
     * @param Request $request
     * @return array
     */
    public function getProfileVersion(Request $request)
    {
        $id = $request->attributes->get('id');
        $userId = $this->token->getToken()->getUser()->getId();

        return
            intval($id) == $userId ? $this->buildPrivateProfile($request) : $this->buildPublicProfile($id)
        ;
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
            'title'        => 'Mon Profil',
            'name'         => $user->getName(),
            'surname'      => $user->getSurname(),
            'email'        => $user->getEmail(),
            'accessLevel'  => $user->getAccessLevel(),
            'creationDate' => $user->getCreatedOn()->format('d-m-Y'),
            'updatePswd'   => $this->updatePswd->changePswd($request)
        ];

        //fetch all user reports
        $reportList =$user->getReports();

        return [
            $accountInfo,
            $this->activitiesTracker
                ->getLastPublicationData($id),
            $reportList,
            $this->activitiesTracker
                ->getActivitiesData($reportList)
        ];
    }

    public function buildPublicProfile($id)
    {
        //fetch profile info from db
        $user = $this->doctrine->getRepository(User::class)
            ->findOneBy(['id'=>$id]);

        //create array with collected data
        $accountInfo = [
            'title'        => 'Profil',
            'name'         => $user->getName(),
            'surname'      => $user->getSurname(),
            'accessLevel'  => $user->getAccessLevel(),
            'creationDate' => $user->getCreatedOn()->format('d-m-Y')
        ];

        //list all reports
        $reportList = $user->getReports();

        return [
            $accountInfo,
            $this->activitiesTracker
                ->getLastPublicationData($id),
            $reportList,
            $this->activitiesTracker
                ->getActivitiesData($reportList)
        ];
    }

}


