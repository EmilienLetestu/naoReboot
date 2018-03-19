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
            ->getManager()
        ;
    }

    /**
     * fin a given account based on email
     */
    public function testFindLogin()
    {
        $this->assertCount(1,
            $this->getUserRepositoryAndTest(__FUNCTION__, 'eletestu@gmail.com')
        );
    }

    /**
     * total of unactivated account eligible to deletion
     */
    public function testFindDeletableAccount()
    {
        $this->assertCount(3,
            $this ->getUserRepositoryAndTest(__FUNCTION__, '-1 day')
        );
    }

    /**
     * total of unactivated account
     */
    public function testCountAllActivated()
    {
        $this->assertCount(5,
            $this->getUserRepositoryAndTest(__FUNCTION__)
        );
    }

    /**
     * total of user with a given access level (role)
     */
    public function testCountAllWithAccessLevel()
    {
        $this->assertCount(1,
            $this->getUserRepositoryAndTest(__FUNCTION__,1)
        );

    }

    /**
     * @param $function
     * @param null $param
     * @return array
     */
    private function getUserRepositoryAndTest($function, $param = null):array
    {
        $repoNameFunction = lcfirst(str_replace('test','',$function));

        return $this->em
            ->getRepository(User::class)
            ->$repoNameFunction($param)
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
