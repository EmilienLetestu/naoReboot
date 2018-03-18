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
       $this->assertCount(1,$this->em
           ->getRepository(Notification::class)
           ->findNotificationForUser(4,0)
       );
    }
}
