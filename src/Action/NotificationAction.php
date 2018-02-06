<?php
/**
 * Created by PhpStorm.
 * User: Emilien
 * Date: 06/02/2018
 * Time: 08:45
 */

namespace App\Action;


use App\Managers\NotificationManager;
use App\Responder\NotificationResponder;

class NotificationAction
{
    /**
     * @var NotificationManager
     */
    private $notificationManager;

    /**
     * NotificationAction constructor.
     * @param NotificationManager $notificationManager
     */
    public function __construct(NotificationManager $notificationManager)
    {
        $this->notificationManager = $notificationManager;
    }

    /**
     * @param NotificationResponder $responder
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function __invoke(NotificationResponder $responder)
    {
        return
            $responder(
                $this->notificationManager
                     ->getNotificationToDisplay()
        );
    }
}
