<?php
/**
 * Created by PhpStorm.
 * User: emilien
 * Date: 11/09/17
 * Time: 15:11
 */

namespace App\Managers;

use App\Entity\Report;
use App\Entity\User;

use Doctrine\ORM\EntityManager;
use Symfony\Component\HttpFoundation\Session\Session;

class UserManager
{


    private $doctrine;
    private $notificationManager;

    /**
     * UserManager constructor.
     * @param EntityManager $doctrine
     * @param NotificationManager $notificationManager
     */
    public  function __construct(
        EntityManager       $doctrine,
        NotificationManager $notificationManager

    )
    {
        $this->doctrine            = $doctrine;
        $this->notificationManager = $notificationManager;
    }

    /**
     * @param $nDaysAgo
     * @return string
     */
    public function deleteAllUnactivated($nDaysAgo)
    {
        $repository = $this->doctrine->getRepository(User::class);
        $userList = $repository->findDeletableAccount($nDaysAgo);

        foreach ($userList as $user )
        {
            $this->doctrine->remove($user);
        }

        $this->doctrine->flush();

        return 'success';
    }

    /**
     * @param $id
     * @return string
     */
    public function deleteUnactivated($id)
    {
        $repository = $this->doctrine->getRepository(User::class);
        $user = $repository->find($id);
        $this->doctrine->remove($user);
        $this->doctrine->flush();

        return 'success';
    }

    /**
     * @param $id
     * @param $nDaysAgo
     * @return mixed
     */
    public function getDelete($id,$nDaysAgo)
    {
       return
           $id === null ?
               $this->deleteAllUnactivated($nDaysAgo) :
               $this->deleteUnactivated($id)
           ;
    }

    /**
     * use for soft delete
     * @param $id
     * @return string
     */
    public function deactivateUser($id)
    {
        $repository = $this->doctrine->getRepository(User::class);
        $user = $repository->findOneById($id);
        $user->setDeactivated(true);
        $this->doctrine->flush();

        return 'success';
    }

    /**
     * @param $id
     * @return string
     */
    public function banUser($id)
    {
        $repository = $this->doctrine->getRepository(User::class);
        $user = $repository->findOneById($id);
        $newStatus = $user->getBan() == 0 ? true : false;
        $user->setBan($newStatus);
        $this->doctrine->persist($user);
        $this->doctrine->flush();

        return 'success';
    }

    /**
     * @param $id
     * @return string
     */
    public function privilegeUser($id)
    {
        $repository = $this->doctrine->getRepository(User::class);
        $user = $repository->findOneBy([
            'id' => $id,
        ]);

        $newLevel = $user->getAccessLevel() > 1 ? 1 : 2;
        $user->setAccessLevel($newLevel);

        if($user->getAccessLevel() === 2){

            $reportList = $user->getReports();

            foreach ($reportList as $report){

                $report->setValidationScore(5);
                $report->setValidated(1);
                $this->doctrine->persist($report);
            }
        }

        $this->notificationManager->notifyUser($newLevel, $user);
        $this->doctrine->persist($user);
        $this->doctrine->flush();

        return 'success';
    }

    /**
     * dedicated to professional registered user
     * validate a professional account request
     * @param $id
     *  @return string
     */
    public function validateUser($id)
    {
        $repository = $this->doctrine->getRepository(User::class);
        $user = $repository->findOneById($id);
        $user->setOnHold(false);
        $this->notificationManager->notifyUser(3, $user);
        $this->doctrine->persist($user);

        $reportList = $user->getReports();

        if($reportList !== null){

            foreach ($reportList as $report){

                $report->setValidationScore(5);
                $report->setValidated(1);
                $this->doctrine->persist($report);
            }

        }

        $this->doctrine->flush();

        return 'success';
    }

    /**
     * dedicated to professional registered user
     * deny a professional account request
     * @param $id
     *  @return string
     */
    public function denyUser($id)
    {
        $repository = $this->doctrine->getRepository(User::class);
        $user = $repository->findOneById($id);
        $user->setOnHold(false);
        $user->setAccessLevel(1);
        $this->notificationManager->notifyUser(4, $user);
        $this->doctrine->persist($user);
        $this->doctrine->flush();

        return 'success';
    }
}

