<?php
/**
 * Created by PhpStorm.
 * User: emilien
 * Date: 29/09/17
 * Time: 09:12
 */

namespace  tests\Repository;

use App\Entity\User;
use App\Repository\UserRepository;
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
            ->getManager()
        ;
    }

    /**
     * total of unactivated account eligible to deletion
     */
    public function testFindDeletableAccount()
    {
        $this->assertCount(3,
            $this->getUserRepository()
            ->findDeletableAccount('-1 day')
        );
    }


    /**
     * fin a given account based on email
     */
    public function testFindLogin()
    {
        $this->assertCount(1,
            $this->getUserRepository()
            ->findLogin('eletestu@gmail.com')
        );
    }

    /**
     * total of unactivated account
     */
    public function testCountAllActivated()
    {
        $this->assertCount(5,
            $this->getUserRepository()
            ->countAllActivated()
        );
    }

    /**
     * total of user with a given access level (role)
     */
    public function testCountAllWithAccessLevel()
    {
        $this->assertCount(1,
            $this->getUserRepository()
            ->countAllWithAccessLevel(1)
        );

    }

    /**
     * list all activated account
     */
    public function testFindAllActivated()
    {
        $userList =  $this->getUserRepository()
            ->findAllActivated()
        ;
        $this->assertSame('Emilien',$userList[0]->getName());

    }

    /**
     * list all "validator" role request
     */
    public function testFindAllAccessLvl2Request()
    {
        $userList = $this->getUserRepository()
            ->findAllAccessLvl2Request()
        ;

        $this->assertCount(1,$userList);
        $this->assertSame('Hank',$userList[0]->getName());
    }



    /**
     * @return UserRepository
     */
    private function getUserRepository():UserRepository
    {
        return $this->em
            ->getRepository(User::class)
        ;
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
