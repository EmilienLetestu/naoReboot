<?php
/**
 * Created by PhpStorm.
 * User: emil
 * Date: 02/10/17
 * Time: 11:37
 */

namespace tests\Repository;

use App\Entity\Report;
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
            $this->getReportRepositoryAndTest(__FUNCTION__)
        );
    }

    /**
     * find homepage eligible reports
     */
    public function testFindAllForHomePage()
    {
        $this->assertCount(2,
            $this->getReportRepositoryAndTest(__FUNCTION__)
        );
    }

    /**
     * last published report for a given user
     */
    public function testFindUserLastPublication()
    {
        $this->assertEquals('Vieux, Normandie',
            $this->getReportRepositoryAndTest(__FUNCTION__,3)
                 ->getLocation()
        );
    }

    /**
     * @param $function
     * @param null $param
     * @return mixed
     */
    private function getReportRepositoryAndTest(string $function,$param = null)
    {
        $repoNameFunction = lcfirst(str_replace('test','',$function));

        return $this->em
            ->getRepository(Report::class)
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

