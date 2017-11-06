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
     * @param $accessLevel
     * @return mixed
     */
    public function deleteAllUnactivated($accessLevel)
    {
        $repository = $this->doctrine->getRepository(User::class);
        $userList = $repository->findDeletableAccount($accessLevel);

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
     * @param $id
     */
    public function softDeleteById($id)
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
        $user->setBan(true);
        $this->doctrine->flush();
    }

    /**
     * @param $id
     * @param $formerLevel
     * @param $newLevel
     */
    public function changeAccessLevel($id,$formerLevel,$newLevel)
    {
        $repository = $this->doctrine->getRepository(User::class);
        $user = $repository->findOneBy([
            'id' => $id,
            'accessLevel' => $formerLevel
        ]);
        $user->setAccessLevel($newLevel);
        $this->notificationManager->notifyUser($type = $newLevel, $user);
        $this->doctrine->flush();
    }

    /**
     * dedicated to users whom registered as professional
     * validate a professional account request
     * @param $id
     */
    public function validateAccountRequest($id)
    {
        $repository = $this->doctrine->getRepository(User::class);
        $user = $repository->findOneById($id);
        $user->setOnHold(false);
        $this->notificationManager->notifyUser($type= 3, $user);
        $this->doctrine->flush();
    }

    /**
     * dedicated to users whom registered as professional
     * deny a professional account request
     * @param $id
     */
    public function requestedAccountDenied($id)
    {
        $repository = $this->doctrine->getRepository(User::class);
        $user = $repository->findOneById($id);
        $user->setOnHold(true);
        $user->setAccessLevel(1);
        $this->notificationManager->notifyUser($type = 4, $user);
        $this->doctrine->flush();
    }
}