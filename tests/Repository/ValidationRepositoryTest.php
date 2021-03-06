<?php
/**
 * Created by PhpStorm.
 * User: emil
 * Date: 02/10/17
 * Time: 14:42
 */

namespace tests\Repository;

use App\Entity\Validation;
use App\Repository\ValidationRepository;
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
        $this->assertCount(1,
            $this->getValidationRepository()
            ->findValidatedReportBy(2)
        );
    }

    /**
     * validation added by a given member
     */
    public function testFindValidationAddedBy()
    {
        $this->assertCount(4,
            $this->getValidationRepository()
            ->findValidationAddedBy(1)
        );
    }

    /**
     * @return ValidationRepository
     */
    private function getValidationRepository():ValidationRepository
    {
        return $this->em
            ->getRepository(Validation::class)
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
