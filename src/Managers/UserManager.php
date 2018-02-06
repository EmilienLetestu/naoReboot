<?php
/**
 * Created by PhpStorm.
 * User: emilien
 * Date: 11/09/17
 * Time: 15:11
 */

namespace App\Managers;

use App\Entity\User;

use Doctrine\ORM\EntityManager;
use Symfony\Component\HttpFoundation\Session\Session;

class UserManager
{


    private $doctrine;
    private $notificationManager;
    private $session;

    /**
     * UserManager constructor.
     * @param EntityManager $doctrine
     * @param NotificationManager $notificationManager
     * @param Session $session
     */
    public  function __construct(
        EntityManager       $doctrine,
        NotificationManager $notificationManager,
        Session             $session
    )
    {
        $this->doctrine            = $doctrine;
        $this->notificationManager = $notificationManager;
        $this->session             = $session;
    }

    /**
     * @param $nDaysAgo
     * @return mixed
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

        return $this->session->getFlashBag()
            ->add('success','Les comptes ont été supprimés')
        ;
    }

    /**
     * @param $nDaysAgo
     * @param $id
     * @return mixed
     */
    public function deleteUnactivated($nDaysAgo, $id)
    {
        $repository = $this->doctrine->getRepository(User::class);
        $user = $repository->findAccountToDelete($nDaysAgo,$id);
        $this->doctrine->remove($user);
        $this->doctrine->flush();

        return $this->session->getFlashBag()
            ->add('success','Le compte a été supprimé')
        ;
    }

    /**
     * @param $id
     * @param $nDaysAgo
     * @return mixed
     */
    public function getDelete($id,$nDaysAgo)
    {
      return $id === null ?
          $this->deleteAllUnactivated($nDaysAgo)
          :
          $this->deleteUnactivated($nDaysAgo,$id)
      ;
    }

    /**
     * use for soft delete
     * @param $id
     */
    public function deactivateUser($id)
    {
        $repository = $this->doctrine->getRepository(User::class);
        $user = $repository->findOneById($id);
        $user->setDeactivated(true);
        $this->doctrine->flush();
    }

    /**
     * @param $id
     */
    public function banUser($id)
    {
        $repository = $this->doctrine->getRepository(User::class);
        $user = $repository->findOneById($id);
        $newStatus = $user->getBan() == 0 ? true : false;
        $user->setBan($newStatus);
        $this->doctrine->persist($user);
        $this->doctrine->flush();
    }

    /**
     * change user access level
     * @param $id
     */
    public function privilegeUser($id)
    {
        $repository = $this->doctrine->getRepository(User::class);
        $user = $repository->findOneBy([
            'id' => $id,

        ]);
        $newLevel = $user->getAccessLevel() > 1 ? 1 : 2;
        $user->setAccessLevel($newLevel);
        $this->notificationManager->notifyUser($newLevel, $user);
        $this->doctrine->persist($user);
        $this->doctrine->flush();
    }

    /**
     * dedicated to professional registered user
     * validate a professional account request
     * @param $id
     */
    public function validateUser($id)
    {
        $repository = $this->doctrine->getRepository(User::class);
        $user = $repository->findOneById($id);
        $user->setOnHold(false);
        $this->notificationManager->notifyUser(3, $user);
        $this->doctrine->persist($user);
        $this->doctrine->flush();
    }

    /**
     * dedicated to professional registered user
     * deny a professional account request
     * @param $id
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
    }
}

