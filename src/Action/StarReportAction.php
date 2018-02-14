<?php
/**
 * Created by PhpStorm.
 * User: Emilien
 * Date: 06/02/2018
 * Time: 08:02
 */

namespace App\Action;


use App\Managers\StarManager;
use App\Responder\StarReportResponder;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class StarReportAction
{
    /**
     * @var StarManager
     */
    private $starManager;

    /**
     * StarReportAction constructor.
     * @param StarManager $starManager
     */
    public function __construct(StarManager $starManager)
    {
        $this->starManager = $starManager;
    }

    /**
     * @param Request $request
     * @param StarReportResponder $responder
     * @return array|string
     */
    public function __invoke(Request $request, StarReportResponder $responder)
    {
        $result = $this->starManager
             ->starProcess($request->get('reportId'))
        ;
        $response = new Response($result);
        $response->headers->set('Content-Type', 'text/xml');

        return $responder(
           $response
        );
    }
}
