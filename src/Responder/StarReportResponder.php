<?php
/**
 * Created by PhpStorm.
 * User: Emilien
 * Date: 06/02/2018
 * Time: 08:03
 */

namespace App\Responder;


class StarReportResponder
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
