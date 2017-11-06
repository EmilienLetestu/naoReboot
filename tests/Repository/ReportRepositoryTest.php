<?php
/**
 * Created by PhpStorm.
 * User: emil
 * Date: 02/10/17
 * Time: 11:37
 */

namespace tests\Repository;

use App\Entity\Report;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

class ReportRepositoryTest extends KernelTestCase
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


    public function testFindAllExpired()
    {
        $report = $this->em
            ->getRepository(Report::class)
            ->findAllExpired();

        $this->assertCount(2, $report);
    }

    /**
     * find all report to display for member with accessLevel 2 or 3
     */
    public function testFindAllDependOnViewer_1()
    {
        $report = $this->em
            ->getRepository(Report::class)
            ->findAllDependOnViewer(
                $birdId    = 1,
                $validated = 0,
                $order     = 'DESC',
                $sort      = 'addedOn',
                $limit     = 10)
            ;

        $this->assertCount(2,$report);
    }

    /**
     * find all report to display for member with accessLevel 1
     */
    public function testFindAllDependOnViewer_2()
    {
        $report = $this->em
            ->getRepository(Report::class)
            ->findAllDependOnViewer(
                $birdId    = 1,
                $validated = 1,
                $order     = 'DESC',
                $sort      = 'addedOn',
                $limit     = 10)
        ;

        $this->assertCount(0,$report);
    }

    public function testFindAllForHomePage()
    {
        $report = $this->em
            ->getRepository(Report::class)
            ->findAllForHomePage()
        ;

        $this->assertCount(0,$report);
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
