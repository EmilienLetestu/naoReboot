<?php
/**
 * Created by PhpStorm.
 * User: Emilien
 * Date: 06/02/2018
 * Time: 17:28
 */

namespace App\Action\Admin;


use App\Entity\Report;
use App\Responder\Admin\ReportedBirdResponder;
use Doctrine\ORM\EntityManagerInterface;

class ReportedBirdAction
{
    private $doctrine;

    public function __construct(EntityManagerInterface $doctrine)
    {
        $this->doctrine = $doctrine;
    }

    public function __invoke(ReportedBirdResponder $responder)
    {
        $repository = $this->doctrine->getRepository(Report::class);
        $reportList = $repository->findAllReport(1);

        foreach ($reportList as $report)
        {
            $birdList[] = $report->getBird()->getId();
        }

        return $responder(array_count_values($birdList));
    }
}
