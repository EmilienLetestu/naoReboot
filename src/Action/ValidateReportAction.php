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
use Symfony\Component\HttpFoundation\Response;

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
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     */
    public function __invoke(Request $request, ValidateReportResponder $responder)
    {
        $this->validationManager
             ->validationProcess($request->get('reportId')
        );

        $response = new Response(
            $this->validationManager
            ->validationProcess($request->get('reportId')
            )
        );

        $response->headers->set('Content-Type', 'text/xml');

        return $responder($response);
    }
}
