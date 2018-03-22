<?php
/**
 * Created by PhpStorm.
 * User: emil
 * Date: 02/10/17
 * Time: 11:37
 */

namespace tests\Repository;

use App\Entity\Report;
use App\Repository\ReportRepository;
use App\Services\ActivitiesTracker;
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

    /**
     * find all reports  eligible for deletion
     */
    public function testFindAllExpired()
    {
        $this->assertCount(0,
            $this->getReportRepository()
            ->findAllExpired()
        );
    }

    /**
     * list report based on a given validation status
     */
    public function testFindAllReport()
    {
        $unvalidatedList = $this->getReportRepository()
            ->findAllReport(0)
        ;
        $this->assertCount(3,$unvalidatedList);
        $this->assertSame('Nimes, Occitanie',$unvalidatedList[1]->getLocation());

        $validatedList = $this->getReportRepository()
            ->findAllReport(1)
        ;
        $this->assertCount(2,$validatedList);
        $this->assertSame('Courseulles, Normandie',$validatedList[1]->getLocation());
    }

    /**
     * list and filter report
     */
    public function testFindSelection()
    {
        $selectionList = $this->getReportRepository()
            ->findSelection(1,'DESC','addedOn')
        ;

        $this->assertCount(2,$selectionList);
        $this->assertSame('Courseulles, Normandie',$selectionList[0]->getLocation());

    }

    public function testFindAllWithBirdName()
    {
        $list = $this->getReportRepository()
            ->findAllWithBirdName(51)
        ;
        $this->assertCount(1,$list);
        $this->assertSame('Chevalier guignette',$list[0]->getBird()->getSpeciesFr());

    }

    /**
     * find homepage eligible reports
     */
    public function testFindAllForHomePage()
    {
        $this->assertCount(2,
            $this->getReportRepository()
            ->findAllForHomePage()
        );
    }

    /**
     * last published report for a given user
     */
    public function testFindUserLastPublication()
    {
        $this->assertEquals('Vieux, Normandie',
            $this->getReportRepository()
            ->findUserLastPublication(3)
            ->getLocation()
        );

    }


    /**
     * @return ReportRepository
     */
    private function getReportRepository():ReportRepository
    {
        return $this->em
            ->getRepository(Report::class)
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

