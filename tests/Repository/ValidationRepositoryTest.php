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
        $this->assertCount(1,
            $this->getValidationRepositoryAndTest(__FUNCTION__,2)
        );
    }

    public function testFindValidationAddedBy()
    {
        $this->assertCount(4,
            $this->getValidationRepositoryAndTest(__FUNCTION__,1)
        );
    }

    private function getValidationRepositoryAndTest($function, $param = null)
    {
        $repoNameFunction = lcfirst(str_replace('test','',$function));

        return $this->em
            ->getRepository(Validation::class)
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
