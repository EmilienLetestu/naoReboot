<?php
/**
 * Created by PhpStorm.
 * User: Emilien
 * Date: 06/02/2018
 * Time: 08:03
 */

namespace App\Responder;


use Symfony\Component\HttpFoundation\Response;

class StarReportResponder
{
    /**
     * @param $result
     * @return Response
     */
   public function __invoke($result)
   {
       $response = new Response($result);
       $response->headers->set('Content-Type', 'text/xml');

       return $response;
   }
}
