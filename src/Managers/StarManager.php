<?php
/**
 * Created by PhpStorm.
 * User: emilien
 * Date: 28/09/17
 * Time: 12:06
 */

namespace App\Managers;

use App\Entity\Report;
use App\Entity\Star;
use App\Entity\User;
use App\Services\Tools;
use Doctrine\ORM\EntityManager;
use Symfony\Component\HttpFoundation\Session\Session;


class StarManager
{
    private $doctrine;

    private $session;

    private $tools;

    public function __construct(
        EntityManager $doctrine,
        Session       $session,
        Tools         $tools
    )
    {
        $this->doctrine  = $doctrine;
        $this->session   = $session;
        $this->tools     = $tools;
    }

    /**
     * @param $reportId
     */
    public function storeStar($reportId)
    {
        //--add star
        //fetch matching Report
        $repository = $this->doctrine->getRepository(Report::class);
        $report = $repository->find($reportId);
        $score =$report->getNbrOfStars();

        //---  get user data from session ---//

        //create a new star object and hydrate it
        $star = new Star();
        $star
            ->setUser($user) // fetch $user from sesssion
            ->setReport($report)
        ;
        //update report with new data
        $report
            ->addStar($star)
            ->setReport($report)
            ->setNbrOfStars($score+1)
        ;
        //store new star into db
        $this->doctrine->getRepository(Star::class);
        $this->doctrine->persist($star);
        $this->flush();
    }
}