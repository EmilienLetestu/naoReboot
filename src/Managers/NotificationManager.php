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

class NotificationManager
{
    private $doctrine;

    /**
     * NotificationManager constructor.
     * @param EntityManager $doctrine
     */
    public function __construct(EntityManager $doctrine)
    {
        $this->doctrine = $doctrine;
    }

    /**
     * @return array
     */
    public function notificationList():array
    {
        $list = ['type_1'=>'Votre niveau de privilège a changé, vous disposé maintenant d\'un compte amateur',
                 'type_2'=>'Félicitations votre compte à été promu, vous disposez à présent d\'un compte naturalise!',
                 'type_3'=>'Votre demande de compte naturaliste à été accepté',
                 'type_4'=>'Votre demande de compte naturaliste à été refusé']
        ;

        return $list;
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
     * Get notifications types and find text to display
     * @param $id
     * @param $seen
     * @return array
     */
    public function getNotificationToDisplay($id,$seen)
    {
        $repository   = $this->doctrine->getRepository(Notification::class);

        $notifications = $repository->findNotificationForUser($id,$seen);

        foreach ($notifications as $notification)
        {
          $types[] =  $notification->getType();

          foreach ($types as $type)
          {
              $list = $this->notificationList();
          }

          $display[] = $list["type_{$type}"];
        }

        return $display;
    }

}