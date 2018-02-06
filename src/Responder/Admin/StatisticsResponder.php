<?php
/**
 * Created by PhpStorm.
 * User: Emilien
 * Date: 06/02/2018
 * Time: 14:32
 */

namespace App\Responder\Admin;


use Symfony\Component\HttpFoundation\Response;
use Twig\Environment;

class StatisticsResponder
{
    /**
     * @var Environment
     */
    private $twig;

    /**
     * StatisticsResponder constructor.
     * @param Environment $twig
     */
    public function __construct(Environment $twig)
    {
        $this->twig = $twig;
    }

    /**
     * @param int $totalReport
     * @param int $monthly
     * @param int $yearly
     * @param float $dailyAvg
     * @param float $monthlyAvg
     * @param float $avgByUser
     * @param int $totalByLevel1
     * @param int $totalByLevel2
     * @param float $avgByLevel1
     * @param float $avgByLevel2
     * @return Response
     */
    public function __invoke(
        int   $totalReport,
        int   $monthly,
        int   $yearly,
        float $dailyAvg,
        float $monthlyAvg,
        float $avgByUser,
        int   $totalByLevel1,
        int   $totalByLevel2,
        float $avgByLevel1,
        float $avgByLevel2
    )
    {
        return new Response(
            $this->twig->render('admin\adminStats.html.twig',[
                'totalReport'     => $totalReport,
                'monthlyTotal'    => $monthly,
                'yearlyTotal'     => $yearly,
                'dailyAverage'    => $dailyAvg,
                'monthlyAverage'  => $monthlyAvg,
                'averageByUser'   => $avgByUser,
                'totalByLevel1'   => $totalByLevel1,
                'totalByLevel2'   => $totalByLevel2,
                'averageByLevel1' => $avgByLevel1,
                'averageByLevel2' => $avgByLevel2
            ])
        );
    }
}