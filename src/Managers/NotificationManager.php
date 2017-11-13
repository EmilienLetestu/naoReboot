<?php
/**
 * Created by PhpStorm.
 * User: emilien
 * Date: 28/09/17
 * Time: 09:07
 */
namespace App\Managers;


use App\Entity\Notification;
use App\Entity\User;
use Doctrine\ORM\EntityManager;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorage;

class NotificationManager
{
    private $doctrine;
    private $token;

    /**
     * NotificationManager constructor.
     * @param EntityManager $doctrine
     * @param TokenStorage $token
     */
    public function __construct(
        EntityManager $doctrine,
        TokenStorage  $token
    )
    {
        $this->doctrine = $doctrine;
        $this->token    = $token;
    }


    /**
     * Add notification to db for a given user
     * @param $type
     * @param User $user
     */
    public function notifyUser($type,User $user)
    {
        $date = date('Y-m-d');
        \DateTime::createFromFormat('Y-m-d',$date);

        $notification = new Notification();
        $notification->setType($type);
        $notification->setSeen(false);
        $notification->setUser($user);
        $notification->setNotifiedOn(\DateTime::createFromFormat('Y-m-d',$date));

        $this->doctrine->getRepository(Notification::class);
        $this->doctrine->persist($notification);
    }

    /**
     * Get notifications to display and update their status to "seen"
     * @return array
     */
    public function getNotificationToDisplay()
    {
        $repository   = $this->doctrine->getRepository(Notification::class);

        $user = $this->token->getToken()->getUser();

        $notificationList = $repository->findNotificationForUser(
            $user->getId(),
            0);

        $this->updateNotificationStatus($notificationList);

        return $notificationList;
    }

    /**
     * @return mixed
     */
    public function checkNotification()
    {
        $repository   = $this->doctrine->getRepository(Notification::class);

        $user = $this->token->getToken()->getUser();

        return $repository->countNotificationForUser(
            $user->getId(),
            0
        );
    }

    /**
     * Set all notification to "seen"
     * @param $notificationList
     */
    public function updateNotificationStatus($notificationList)
    {
        //get notification to update
        foreach ($notificationList as $notification)
        {
            $notification->setSeen(1);

            $this->doctrine->persist($notification);
        }

        $this->doctrine->flush();
    }

}

