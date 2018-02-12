<?php
/**
 * Created by PhpStorm.
 * User: Emilien
 * Date: 06/02/2018
 * Time: 08:03
 */

namespace App\Responder;

use Symfony\Component\HttpFoundation\RedirectResponse;

class StarReportResponder
{
   /**
    * @param string $referer
    * @return RedirectResponse
   */
   public function __invoke(string $referer)
   {
      return new RedirectResponse($referer);
   }
}
