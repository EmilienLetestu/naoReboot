<?php
/**
 * Created by PhpStorm.
 * User: emil
 * Date: 02/10/17
 * Time: 12:13
 */

namespace tests\Repository;

use App\Entity\Star;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

class starRepositoryTest extends KernelTestCase
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

        $this->em =static::$kernel->getContainer()
            ->get('doctrine')
            ->getManager();
    }


    /**
     * number of stars for a given report
     */
    public function testFindStaredReportBy()
    {
        $this->assertCount(0,
            $this->getStarRepositoryAndTest(__FUNCTION__,1)
        );
    }

    /**
     * stars added by a given user
     */
    public function testFindStarAddedBy()
    {
        $this->assertCount(0,
            $this->getStarRepositoryAndTest(__FUNCTION__,0)
        );
    }

    /**
     * @param $function
     * @param null $param
     * @return array
     */
    private function getStarRepositoryAndTest($function,$param = null):array
    {
        $repoNameFunction = lcfirst(str_replace('test','',$function));

        return $this->em
            ->getRepository(Star::class)
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
