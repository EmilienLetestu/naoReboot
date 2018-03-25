<?php
/**
 * Created by PhpStorm.
 * User: Emilien
 * Date: 25/03/2018
 * Time: 11:34
 */

namespace App\Responder\Admin;


use Symfony\Component\HttpFoundation\Response;

class DeleteReportResponder
{
    public function __invoke($result)
    {
       $response = new Response($result);
       $response->headers->set('Content-Type', 'text/xml');

       return $response;
    }
}
