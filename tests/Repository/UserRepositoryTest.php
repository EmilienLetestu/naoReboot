<?php
/**
 * Created by PhpStorm.
 * User: emilien
 * Date: 29/09/17
 * Time: 09:12
 */

namespace  tests\Repository;

use App\Entity\User;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

class UserRepositoryTest extends KernelTestCase
{
    /**
     * @var \Doctrine\ORM\EntityManager
     */
    private $em;

    /**
     * {@inheritDoc}
     */
    protected function setUp()
    {
        self::bootKernel();

        $this->em = static::$kernel->getContainer()
            ->get('doctrine')
            ->getManager();
    }

    public function testFindLogin()
    {
        $user = $this->em
            ->getRepository(User::class)
            ->findLogin('eletestu@gmail.com')
        ;

        $this->assertCount(1, $user);
    }

    public function testFindDeletableAccount()
    {
        $accessLevel = 2;
        $nMonthAgo   = "-1 day";

        $user = $this->em
            ->getRepository(User::class)
            ->findDeletableAccount($accessLevel,$nMonthAgo)
        ;

        $this->assertCount(1, $user);
    }

    /**
     * {@inheritDoc}
     */
    protected function tearDown()
    {
        parent::tearDown();

        $this->em->close();
        $this->em = null;
    }
}