<?php

/**
 * Created by PhpStorm.
 * User: Emilien
 * Date: 06/02/2018
 * Time: 10:12
 */

namespace App\Responder\Admin;




use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\ResponseHeaderBag;

class ExportCsvResponder
{
    /**
     * @param $fileContent
     * @return Response
     */
    public function __invoke($fileContent)
    {
        $response = new Response( str_replace(',', ';', $fileContent));

        $filename = 'data.csv';

        $disposition = $response->headers->makeDisposition(
            ResponseHeaderBag::DISPOSITION_ATTACHMENT,
            $filename
        );
        $response->headers->set('Content-Disposition', $disposition);

        return $response;
    }
}
