<?php
/**
 * Created by PhpStorm.
 * User: Emilien
 * Date: 06/02/2018
 * Time: 08:28
 */

namespace App\Responder;

use Symfony\Component\HttpFoundation\RedirectResponse;

class ValidateReportResponder
{

    /**
     * @param $response
     * @return mixed
     */
    public function __invoke($response)
    {
        return $response;
    }
}
