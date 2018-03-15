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
            ->getManager()
        ;
    }


    public function testFindAllExpired()
    {
        $report = $this->em
            ->getRepository(Report::class)
            ->findAllExpired();

        $this->assertCount(1, $report);
    }



    public function testFindAllForHomePage()
    {
        $report = $this->em
            ->getRepository(Report::class)
            ->findAllForHomePage()
        ;

        $this->assertCount(2,$report);
    }

    public function testFindUserLastPublication()
    {
         $report = $this->em
            ->getRepository(Report::class)
            ->findUserLastPublication(3)
        ;

        $this->assertEquals('Vieux, Normandie',$report->getLocation());
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
