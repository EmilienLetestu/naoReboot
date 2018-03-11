<?php
/**
 * Created by PhpStorm.
 * User: Emilien
 * Date: 16/11/2017
 * Time: 10:39
 */

namespace App\Services;

use App\Entity\Report;
use Doctrine\ORM\EntityManager;

class Search
{

    /**
     * @var EntityManager
     */
    private $doctrine;


    /**
     * Search constructor.
     * @param EntityManager $doctrine
     */
    public function __construct(EntityManager $doctrine)
    {
        $this->doctrine     = $doctrine;
    }

    /**
     * @return mixed
     */
    public function getValidatedContent(){
        $repository = $this->doctrine->getRepository(Report::class);

        return $repository->findAllReport(1);
    }
}

