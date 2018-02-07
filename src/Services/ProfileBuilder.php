<?php
/**
 * Created by PhpStorm.
 * User: emil
 * Date: 03/10/17
 * Time: 23:01
 */

namespace App\Services;

use App\Entity\User;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;

class ProfileBuilder
{
    private $doctrine;

    /**
     * ProfileBuilder constructor.
     * @param EntityManagerInterface $doctrine
     */
    public function __construct(
        EntityManagerInterface     $doctrine
    )
    {
        $this->doctrine  = $doctrine;
    }

    /**
     * @param Request $request
     * @return array
     */
    public function getProfileVersion($request, $id, $userId, $user, $activitiesTracker, $updatePswd)
    {
        return
            intval($id) == $userId ?
                $this->buildPrivateProfile($request, $user, $activitiesTracker, $updatePswd) :
                $this->buildPublicProfile($id, $activitiesTracker)
        ;
    }

    /**
     * @param Request $request
     * @return array
     */
    public function buildPrivateProfile($request, $user, $activitiesTracker, $updatePswd)
    {
        $id          = $user->getId();
        //create array with account creation date, chg pswd process and account type
        $accountInfo = [
            'title'        => 'Mon Profil',
            'name'         => $user->getName(),
            'surname'      => $user->getSurname(),
            'email'        => $user->getEmail(),
            'accessLevel'  => $user->getAccessLevel(),
            'creationDate' => $user->getCreatedOn()->format('d-m-Y'),
            'updatePswd'   => $updatePswd->changePswd($request)
        ];

        //fetch all user reports
        $reportList =$user->getReports();

        return [
            $accountInfo,
            $activitiesTracker
                ->getLastPublicationData($id),
            $reportList,
            $activitiesTracker
                ->getActivitiesData($reportList)
        ];
    }

    public function buildPublicProfile($id,$activitiesTracker)
    {
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
            $activitiesTracker
                ->getLastPublicationData($id),
            $reportList,
            $activitiesTracker
                ->getActivitiesData($reportList)
        ];
    }
}


