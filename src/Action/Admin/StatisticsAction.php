<?php
/**
 * Created by PhpStorm.
 * User: Emilien
 * Date: 06/02/2018
 * Time: 14:30
 */

namespace App\Action\Admin;


use App\Entity\Report;
use App\Entity\User;
use App\Responder\Admin\StatisticsResponder;
use App\Services\Tools;
use Doctrine\ORM\EntityManagerInterface;


class StatisticsAction
{
    /**
     * @var EntityManagerInterface
     */
    private $doctrine;

    /**
     * @var Tools
     */
    private $tools;

    /**
     * StatisticsAction constructor.
     * @param EntityManagerInterface $doctrine
     * @param Tools $tools
     */
    public function __construct(
        EntityManagerInterface $doctrine,
        Tools                  $tools
    )
    {
        $this->doctrine = $doctrine;
        $this->tools    = $tools;
    }

    /**
     * @param StatisticsResponder $responder
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function __invoke(StatisticsResponder $responder)
    {
        $repoReport = $this->doctrine->getRepository(Report::class);
        $repoUser   = $this->doctrine->getRepository(User::class);

        $diff = $this->tools->getTimeElapsed();

        //total
        $totalReport = count(
            $repoReport->countAllValidated()
        );
        $totalUser = count(
            $repoUser->countAllActivated()
        );

        // reference values for user based stats
        $allReportByUserLevel2 = count(
            $repoReport->countWithUserAccessLevel(1)
        );
        $allReportByUserLevel1 = count(
            $repoReport->countWithLowerAccessLevel()
        );

        return $responder(
            $totalReport,
            count($repoReport->countValidatedThisMonth(date('Y'),date('m'))),
            count($repoReport->countValidatedThisYear(date('Y'))),
            $totalReport / $diff['days'],
            $totalReport / $diff['months'],
            $totalReport / $totalUser,
            $allReportByUserLevel1,
            $allReportByUserLevel2,
            $allReportByUserLevel1 > 0 ? $totalReport / $allReportByUserLevel1 : 0,
            $allReportByUserLevel2 > 0 ? $totalReport / $allReportByUserLevel2 : 0
        );
    }
}
