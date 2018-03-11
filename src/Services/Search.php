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
use Symfony\Component\HttpFoundation\Session\SessionInterface;

class Search
{

    /**
     * @var EntityManager
     */
    private $doctrine;
    private $session;


    /**
     * Search constructor.
     * @param EntityManager $doctrine
     */
    public function __construct(
        EntityManager $doctrine,
        SessionInterface $session
    )
    {
        $this->doctrine     = $doctrine;
        $this->session      = $session;
    }

    /**
     * @return mixed
     */
    public function getValidatedContent(){

        $repository = $this->doctrine->getRepository(Report::class);
        $this->session->set('dbLoaded',1);

        return $repository->findAllReport(1);
    }
}

