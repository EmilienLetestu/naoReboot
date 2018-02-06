<?php

/**
 * Created by PhpStorm.
 * User: Emilien
 * Date: 06/02/2018
 * Time: 10:12
 */

namespace App\Responder\Admin;


use Symfony\Component\HttpFoundation\RedirectResponse;

class ExportCsvResponder
{
    /**
     * @param $response
     * @return RedirectResponse
     */
    public function __invoke($response)
    {
      return $response;
    }
}