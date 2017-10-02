<?php
/**
 * Created by PhpStorm.
 * User: emil
 * Date: 02/10/17
 * Time: 15:04
 */

namespace tests\Repository;

use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;
use App\Entity\Notification;

class NotificationRepositoryTest extends KernelTestCase
{
    /**
     * @var \Doctrine\ORM\EntityManager
     */
    private $em;

    /**
     * {@inheritdoc}
     */
    public function setUp()
    {
        self::bootKernel();

        $this->em = static::$kernel->getContainer()
            ->get('doctrine')
            ->getManager()
        ;
    }

    /**
     * fetch all notification for a given user
     */
    public function testFindNotificationForUser()
    {
       $notification = $this->em
           ->getRepository(Notification::class)
           ->findNotificationForUser(
               $id = 3,
               $seen = 0
           )
       ;

       $this->assertCount(1,$notification);
    }
}