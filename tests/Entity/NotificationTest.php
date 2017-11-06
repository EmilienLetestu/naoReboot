<?php
/**
 * Created by PhpStorm.
 * User: emilien
 * Date: 04/09/17
 * Time: 13:56
 */

namespace tests\Entity;

use App\Entity\Notification;
use Symfony\Bundle\FrameworkBundle\Tests\TestCase;

/**
 * Class NotificationTest
 * @package tests\Entity
 */
class NotificationTest extends TestCase
{
    public function testNotification()
    {
        $notification = new Notification();

        $notification->setType(3);
        $notification->setSeen(true);

        static::assertEquals(3, $notification->getType());
        static::assertEquals(true, $notification->getSeen());
    }
}
