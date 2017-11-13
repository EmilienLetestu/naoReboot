<?php
/**
 * Created by PhpStorm.
 * User: Emilien
 * Date: 13/11/2017
 * Time: 16:17
 */

namespace App\Twig;


use App\Managers\NotificationManager;

class CheckNotificationTypeExtension extends \Twig_Extension
{
    private $notificationManager;

    public  function __construct(
        NotificationManager $notificationManager
    )
    {
        $this->notificationManager = $notificationManager;
    }

    public function getFilters()
    {
        return [
          new \Twig_SimpleFilter('countNotif',[$this,'checkNotificationFilter'])
        ];
    }

    public function checkNotificationFilter()
    {
       $total = count($this->notificationManager->checkNotification());
       return $total > 0 ? $total : null ;
    }
}
