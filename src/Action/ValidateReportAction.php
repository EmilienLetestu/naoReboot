<?php
/**
 * Created by PhpStorm.
 * User: Emilien
 * Date: 06/02/2018
 * Time: 08:28
 */

namespace App\Action;

use App\Managers\ValidationManager;
use App\Responder\ValidateReportResponder;
use Symfony\Component\HttpFoundation\Request;

class ValidateReportAction
{
    /**
     * @var ValidationManager
     */
    private $validationManager;

    /**
     * ValidateReportAction constructor.
     * @param ValidationManager $validationManager
     */
    public function __construct(ValidationManager $validationManager)
    {
        $this->validationManager = $validationManager;
    }

    /**
     * @param Request $request
     * @param ValidateReportResponder $responder
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function __invoke(Request $request, ValidateReportResponder $responder)
    {
        return $responder(
            $this->validationManager
            ->validationProcess($request->get('reportId'))
        );
    }
}
