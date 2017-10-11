<?php
/**
 * Created by PhpStorm.
 * User: emilien
 * Date: 28/09/17
 * Time: 17:24
 */

namespace App\Managers;


use App\Entity\Report;
use Doctrine\ORM\EntityManager;
use Symfony\Component\HttpFoundation\Session\Session;

class ReportManager
{
    private $doctrine;
    private $session;

    /**
     * ReportManager constructor.
     * @param EntityManager $doctrine
     * @param Session $session
     */
    public function __construct(
        EntityManager $doctrine,
        Session       $session
    )
    {
        $this->doctrine = $doctrine;
        $this->session  = $session;
    }

    public function deleteAllExpired()
    {
        $repository = $this->doctrine->getRepository(Report::class);
        $deleteList = $repository->findAllExpired();

        $this->doctrine->remove($deleteList);
        $this->doctrine->flush();
    }

    public function displayHomePageReport()
    {
        $repository = $this->doctrine->getRepository(Report::class);
        $reportList = $repository->findAllForHomePage();

        return $reportList;
    }
}