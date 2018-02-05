<?php
/**
 * Created by PhpStorm.
 * User: Emilien
 * Date: 05/02/2018
 * Time: 10:56
 */

namespace App\Responder;


use Symfony\Component\HttpFoundation\Response;
use Twig\Environment;

class BrowseReportResponder
{
    /**
     * @var Environment
     */
    private $twig;

    /**
     * BrowseReportResponder constructor.
     * @param Environment $twig
     */
    public function __construct(Environment $twig)
    {
        $this->twig = $twig;
    }

    /**
     * @param $filter
     * @param $reports
     * @param $title
     * @param $birdId
     * @return Response
     */
    public function __invoke($filter,$reports,$title,$birdId)
    {
       return new Response(
           $this->twig->render('nao\browseReport.html.twig',[
               'filter'   => $filter,
               'reports'  => $reports,
               'title'    => $title,
               'birdId'   => $birdId
           ])
       );
    }
}