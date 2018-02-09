<?php
/**
 * Created by PhpStorm.
 * User: Emilien
 * Date: 06/02/2018
 * Time: 10:41
 */

namespace App\Responder\Admin;




use Symfony\Component\Form\FormView;
use Symfony\Component\HttpFoundation\Response;
use Twig\Environment;

class AdminHomeResponder
{
    /**
     * @var Environment
     */
    private $twig;

    /**
     * AdminHomeResponder constructor.
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
     * @param array $homeImg
     * @param FormView $form
     * @param string $title
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
        float $avgByLevel2,
         array $homeImg,
        FormView $form,
        string $title
    )
    {
        return new Response(
            $this->twig->render('admin\admin.html.twig',[
                'totalReport'     => $totalReport,
                'monthlyTotal'    => $monthly,
                'yearlyTotal'     => $yearly,
                'dailyAverage'    => $dailyAvg,
                'monthlyAverage'  => $monthlyAvg,
                'averageByUser'   => $avgByUser,
                'totalByLevel1'   => $totalByLevel1,
                'totalByLevel2'   => $totalByLevel2,
                'averageByLevel1' => $avgByLevel1,
                'averageByLevel2' => $avgByLevel2,
                'homeImg'         => $homeImg,
                'form'            => $form,
                'title'           => $title
            ])
        );
    }
}