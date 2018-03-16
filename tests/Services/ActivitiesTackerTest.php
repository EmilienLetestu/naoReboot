<?php
/**
 * Created by PhpStorm.
 * User: Emilien
 * Date: 16/03/2018
 * Time: 14:17
 */

namespace test\Services;

use App\Services\ActivitiesTracker;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;
use tests\Repository\starRepositoryTest;

class ActivitiesTackerTest extends KernelTestCase
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


    public function testActivitiesTracker(){

        $activity = new ActivitiesTracker($this->em);

        $activityList = $activity->getLastPublicationData(1);
        static::assertEquals('-------------',$activityList[0]);

        $lastData = $activity->getLastReportedData(21);
        static::assertEquals('49.3334059, -0.4573649999999816',$lastData[1]);
    }
    
}
