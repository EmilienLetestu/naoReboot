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
     * @param $request
     * @param $id
     * @param $userId
     * @param $user
     * @param $activitiesTracker
     * @param $updatePswd
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
     * @param $request
     * @param User $user
     * @param ActivitiesTracker $activitiesTracker
     * @param UpdatePswd $updatePswd
     * @return array
     */
    public function buildPrivateProfile($request, User $user, ActivitiesTracker $activitiesTracker, UpdatePswd $updatePswd)
    {
        $id          = $user->getId();

        $accountInfo = [
            'title'        => 'Mon Profil',
            'name'         => $user->getName(),
            'surname'      => $user->getSurname(),
            'email'        => $user->getEmail(),
            'accessLevel'  => $user->getAccessLevel(),
            'creationDate' => $user->getCreatedOn()->format('d-m-Y'),
            'updatePswd'   => $updatePswd->changePswd($request)
        ];

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

    /**
     * @param $id
     * @param ActivitiesTracker $activitiesTracker
     * @return array
     */
    public function buildPublicProfile($id, ActivitiesTracker $activitiesTracker)
    {
        $user = $this->doctrine->getRepository(User::class)
            ->findOneBy(['id'=>$id]);

        if(!$user->getDeactivated()){

            $accountInfo = [
                'title'        => 'Profil',
                'name'         => $user->getName(),
                'surname'      => $user->getSurname(),
                'accessLevel'  => $user->getAccessLevel(),
                'creationDate' => $user->getCreatedOn()->format('d-m-Y'),
                'email'        => $user->getEmail()
            ];

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
}


