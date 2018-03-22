<?php
/**
 * Created by PhpStorm.
 * User: emil
 * Date: 02/10/17
 * Time: 12:13
 */

namespace tests\Repository;

use App\Entity\Star;
use App\Repository\StarRepository;
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
            $this->getStarRepository()
            ->findStaredReportBy(1)
        );
    }

    /**
     * stars added by a given user
     */
    public function testFindStarAddedBy()
    {
        $this->assertCount(0,
            $this->getStarRepository()
            ->findStarAddedby(1)
        );
    }

    /**
     * @return StarRepository
     */
    private function getStarRepository():StarRepository
    {
        return $this->em
            ->getRepository(Star::class)

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
