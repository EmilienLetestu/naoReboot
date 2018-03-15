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


    public function testFindStaredReportBy()
    {
        $star = $this->em
            ->getRepository(Star::class)
            ->findStaredReportBy($id = 1)
        ;

        $this->assertCount(0,$star);
    }

    public function testFindStarAddedBy()
    {
        $star = $this->em
            ->getRepository(Star::class)
            ->findStarAddedBy($id = 3)
        ;

        $this->assertCount(0,$star);
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
