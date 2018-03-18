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

    public function testFindLogin()
    {
        $this->assertCount(1,
            $this->getUserRepositoryAndTest(__FUNCTION__, 'eletestu@gmail.com')
        );
    }

    public function testFindDeletableAccount()
    {
        $this->assertCount(3,
            $this ->getUserRepositoryAndTest(__FUNCTION__, '-1 day')
        );
    }

    public function testCountAllActivated()
    {
        $this->assertCount(5,
            $this->getUserRepositoryAndTest(__FUNCTION__)
        );
    }

    public function testCountAllWithAccessLevel()
    {
        $this->assertCount(1,
            $this->getUserRepositoryAndTest(__FUNCTION__,1)
        );

    }

    private function getUserRepositoryAndTest($function, $param = null)
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
