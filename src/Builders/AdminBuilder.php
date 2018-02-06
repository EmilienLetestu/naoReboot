<?php
/**
 * Created by PhpStorm.
 * User: emil
 * Date: 05/10/17
 * Time: 12:50
 */

namespace App\Builders;

use App\Entity\Report;
use App\Entity\User;

use App\Managers\UserManager;
use App\Services\HomeImg;
use Doctrine\ORM\EntityManager;
use Symfony\Component\HttpFoundation\Request;

class AdminBuilder
{
    private $doctrine;
    private $homeImg;
    private $userManager;


    public function __construct(
        EntityManager $doctrine,
        HomeImg       $homeImg,
        UserManager   $userManager
    )
    {
        $this->doctrine    = $doctrine;
        $this->homeImg     = $homeImg;
        $this->userManager = $userManager;
    }


    /**
     * @return array
     */
    public function buildReportedBird()
    {
        $repository = $this->doctrine->getRepository(Report::class);
        $reportList = $repository->findAllReport(1);

        foreach ($reportList as $report)
        {
          $birdList[] = $report->getBird()->getId();
        }

        return array_count_values($birdList);
    }
}



