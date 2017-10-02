<?php
/**
 * Created by PhpStorm.
 * User: emil
 * Date: 02/10/17
 * Time: 14:42
 */

namespace tests\Repository;

use App\Entity\Validation;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;
class ValidationRepositoryTest extends KernelTestCase
{
    /**
     * @var \Doctrine\ORM\EntityManager
     */
    private $em;

    public function setUp()
    {
        self::bootKernel();

        $this->em = static::$kernel->getContainer()
            ->get('doctrine')
            ->getManager()
        ;
    }

    /**
     * number of validation for a given report
     */
    public function testFindValidatedReportBy()
    {
        $validation = $this->em
            ->getRepository(Validation::class)
            ->findValidatedReportBy($id = 1)
        ;

        $this->assertCount(1,$validation);
    }

    public function testFindValidationAddedBy()
    {
        $validation = $this->em
            ->getRepository(Validation::class)
            ->findValidationAddedBy($id = 2)
        ;

        $this->assertCount(2, $validation);
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