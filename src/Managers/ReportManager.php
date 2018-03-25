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

class ReportManager
{
    private $doctrine;

    /**
     * ReportManager constructor.
     * @param EntityManager $doctrine
     */
    public function __construct(EntityManager $doctrine)
    {
        $this->doctrine = $doctrine;
    }

    /**
     *  delete all reports which remain unvalidated after 60 days
     */
    public function deleteAllExpired()
    {
        $repository = $this->doctrine->getRepository(Report::class);
        $deleteList = $repository->findAllExpired();

        foreach ($deleteList as $report){

            if($report->getPictRef()!== null){
                unlink("../public/userImages/{$report->getPictRef()}");
            }

            $this->doctrine->remove($report);
        }

        $this->doctrine->flush();
    }

    /**
     * @return mixed
     */
    public function displayHomePageReport()
    {
        $repository = $this->doctrine->getRepository(Report::class);

        return $repository->findAllForHomePage();
    }

    /**
     * @return mixed
     */
    public function displayAllValidated()
    {
       $repository = $this->doctrine->getRepository(Report::class);

       return $repository->findAllReport(1);
    }

    /**
     * @return mixed
     */
    public function displayAllUnvalidated()
    {
        $this->deleteAllExpired();
        $repository = $this->doctrine->getRepository(Report::class);

        return $repository->findAllReport(0);
    }

    /**
     * @param $id
     * @return string
     */
    public function deleteReport($id)
    {
        $report = $this->doctrine
            ->getRepository(Report::class)
            ->findReport($id)
        ;

        if($report->getPictRef()!== null){
            unlink("../public/userImages/{$report->getPictRef()}");
        }

        $this->doctrine->remove($report);
        $this->doctrine->flush();

        return 'success';
    }


}

