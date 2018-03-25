<?php
/**
 * Created by PhpStorm.
 * User: Emilien
 * Date: 25/03/2018
 * Time: 11:21
 */

namespace App\Action\Admin;


use App\Managers\ReportManager;
use App\Responder\Admin\DeleteReportResponder;
use Symfony\Component\HttpFoundation\Request;

class DeleteReportAction
{
    private $reportManager;


    public function __construct(ReportManager $reportManager)
    {
        $this->reportManager = $reportManager;
    }


    public function __invoke(Request $request, DeleteReportResponder $responder)
    {
        return $responder(
            $this->reportManager
                ->deleteReport($request->get('reportId'))
        );
    }
}
